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
                    <JsTable :data="tableData" @create="showCreateModal" @update="showUpdateModal"
                        @delete="handleDelete" />
                    <JsModal :visible="isModalVisible" :title="modalTitle" :confirmText="modalButtonText"
                        :formData="currentRow" @cancel="hideModal" @confirm="handleConfirm" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import JsTable from '@/CustomComponents/JsTable.vue';
import JsModal from '@/CustomComponents/JsModal.vue';

const tableData = ref([
    { id: 1, mac_address: '1557-4546-566+5', label: 'john@example.com' },
    { id: 2, mac_address: '9585-565-185', label: 'jane@example.com' },
]);

const isModalVisible = ref(false);
const modalTitle = ref('');
const modalButtonText = ref('');
const currentRow = ref({});

const showCreateModal = (newRow) => {
    modalTitle.value = 'Create New Entry';
    modalButtonText.value = 'Create';
    currentRow.value = newRow;
    isModalVisible.value = true;
};

const showUpdateModal = (row) => {
    modalTitle.value = 'Update Entry';
    modalButtonText.value = 'Update';
    currentRow.value = { ...row };
    isModalVisible.value = true;
};

const hideModal = () => {
    isModalVisible.value = false;
};

const handleConfirm = (updatedRow) => {
    if (modalButtonText.value === 'Update') {
        const index = tableData.value.findIndex((row) => row.id === updatedRow.id);
        tableData.value[index] = updatedRow;
    } else {
        updatedRow.id = tableData.value.length + 1; // Assign a new ID
        tableData.value.push(updatedRow);
    }
    hideModal();
};

const handleDelete = (row) => {
    tableData.value = tableData.value.filter((item) => item.id !== row.id);
};
</script>
