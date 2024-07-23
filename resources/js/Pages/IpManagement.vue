<template>
    <AppLayout title="Ip Management">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Ip Management
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="flex justify-end p-4">
                        <button @click="showCreateModal"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create New Entry
                        </button>
                    </div>
                    <JsTable :data="tableData" @update="showUpdateModal" />
                    <JsModal :visible="isModalVisible" :title="modalTitle" :confirmText="modalButtonText"
                        :formData="currentRow" :isUpdate="isUpdate" @cancel="hideModal" @confirm="handleConfirm"
                        ref="modal" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import JsTable from '@/CustomComponents/JsTable.vue';
import JsModal from '@/CustomComponents/JsModal.vue';

const tableData = ref([]);
const isModalVisible = ref(false);
const modalTitle = ref('');
const modalButtonText = ref('');
const currentRow = ref({});
const currentUser = ref({});
const isUpdate = ref(false);

const modal = ref(null);

// Fetch the API token and use it to fetch data
const fetchTokenAndData = async () => {
    try {
        // Get the API token
        const tokenResponse = await axios.get('/generate-token');
        const token = tokenResponse.data.token;

        // Fetch current user
        const userResponse = await axios.get('/api/user', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        currentUser.value = userResponse.data;

        // Fetch IP management data with relationships
        const response = await axios.get('/api/ip-management', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        tableData.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

onMounted(fetchTokenAndData);

const showCreateModal = () => {
    modalTitle.value = 'Create New Entry';
    modalButtonText.value = 'Create';
    currentRow.value = { mac_address: '', label: '' }; // Ensure currentRow has default values for required fields
    isUpdate.value = false;
    isModalVisible.value = true;
    modal.value.clearErrors();
};

const showUpdateModal = (row) => {
    modalTitle.value = 'Update Entry';
    modalButtonText.value = 'Update';
    currentRow.value = { ...row }; // Ensure the id is included in currentRow
    isUpdate.value = true;
    isModalVisible.value = true;
    modal.value.clearErrors();
};

const hideModal = () => {
    isModalVisible.value = false;
};

const handleConfirm = async (updatedRow) => {
    try {
        // Get the API token
        const tokenResponse = await axios.get('/generate-token');
        const token = tokenResponse.data.token;

        if (isUpdate.value) {
            await axios.put(`/api/ip-management/${currentRow.value.id}`, updatedRow, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });
        } else {
            const response = await axios.post('/api/ip-management', updatedRow, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });
            tableData.value.push(response.data);
        }

        // Fetch updated data from the API to ensure relationships are included
        const response = await axios.get('/api/ip-management', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        tableData.value = response.data;

        hideModal(); // Close the modal after successful operation
    } catch (error) {
        if (error.response && error.response.status === 422) {
            modal.value.errors.mac_address = error.response.data.errors.mac_address ? error.response.data.errors.mac_address[0] : null;
            modal.value.errors.label = error.response.data.errors.label ? error.response.data.errors.label[0] : null;
        } else {
            console.error('Error saving data:', error);
        }
    }
};
</script>
