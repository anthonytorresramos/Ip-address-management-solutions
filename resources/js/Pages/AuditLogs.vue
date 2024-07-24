<template>
    <AppLayout title="Audit Logs">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Audit Logs
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="flex justify-between mb-4">
                        <div class="flex space-x-2">
                            <select v-model="selectedIpAddress" @change="filterLogs" class="w-auto p-2 border rounded">
                                <option value="">All Ip Addresses</option>
                                <option v-for="mac in ipAddresses" :key="mac" :value="mac">{{ mac }}</option>
                            </select>
                            <select v-model="selectedUser" @change="filterLogs" class="w-auto p-2 border rounded">
                                <option value="">All Users</option>
                                <option v-for="user in users" :key="user" :value="user">{{ user }}</option>
                            </select>
                        </div>
                    </div>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th @click="sortTable('ip_address')"
                                    class="px-4 py-2 text-left border-b cursor-pointer">
                                    Ip Address
                                    <span v-if="sortKey === 'ip_address'">
                                        <span v-if="sortDirection === 'asc'">▲</span>
                                        <span v-else>▼</span>
                                    </span>
                                </th>
                                <th @click="sortTable('label')" class="px-4 py-2 text-left border-b cursor-pointer">
                                    Label
                                    <span v-if="sortKey === 'label'">
                                        <span v-if="sortDirection === 'asc'">▲</span>
                                        <span v-else>▼</span>
                                    </span>
                                </th>
                                <th @click="sortTable('action')" class="px-4 py-2 text-left border-b cursor-pointer">
                                    Action
                                    <span v-if="sortKey === 'action'">
                                        <span v-if="sortDirection === 'asc'">▲</span>
                                        <span v-else>▼</span>
                                    </span>
                                </th>
                                <th @click="sortTable('user.email')"
                                    class="px-4 py-2 text-left border-b cursor-pointer">
                                    User Email
                                    <span v-if="sortKey === 'user.email'">
                                        <span v-if="sortDirection === 'asc'">▲</span>
                                        <span v-else>▼</span>
                                    </span>
                                </th>
                                <th @click="sortTable('created_at')"
                                    class="px-4 py-2 text-left border-b cursor-pointer">
                                    Date
                                    <span v-if="sortKey === 'created_at'">
                                        <span v-if="sortDirection === 'asc'">▲</span>
                                        <span v-else>▼</span>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(log, index) in paginatedLogs" :key="index">
                                <td class="px-4 py-2 text-left border-b">{{ log.ip_management.ip_address }}</td>
                                <td class="px-4 py-2 text-left border-b">{{ log.label }}</td>
                                <td class="px-4 py-2 text-left border-b">
                                    <span
                                        :class="{ 'bg-green-500 text-white': log.action === 'created', 'bg-blue-500 text-white': log.action === 'updated' }"
                                        class="px-2 py-1 rounded">
                                        {{ log.action }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-left border-b">{{ log.user.email }}</td>
                                <td class="px-4 py-2 text-left border-b">{{ formatDate(log.created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-end mt-4">
                        <button class="px-3 py-1 bg-gray-200 border rounded-l hover:bg-gray-300"
                            :disabled="currentPage === 1" @click="previousPage">
                            Previous
                        </button>
                        <button class="px-3 py-1 bg-gray-200 border-t border-b hover:bg-gray-300"
                            v-for="page in totalPages" :key="page" @click="changePage(page)"
                            :class="{ 'bg-gray-300': currentPage === page }">
                            {{ page }}
                        </button>
                        <button class="px-3 py-1 bg-gray-200 border rounded-r hover:bg-gray-300"
                            :disabled="currentPage === totalPages" @click="nextPage">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

const auditLogs = ref([]);
const filteredLogs = ref([]);
const ipAddresses = ref([]);
const users = ref([]);
const selectedIpAddress = ref('');
const selectedUser = ref('');
const sortKey = ref('');
const sortDirection = ref('asc');

const currentPage = ref(1);
const itemsPerPage = 10;

const paginatedLogs = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredLogs.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(filteredLogs.value.length / itemsPerPage);
});

const fetchAuditLogs = async () => {
    try {
        const tokenResponse = await axios.get('/generate-token');
        const token = tokenResponse.data.token;

        const response = await axios.get('/api/audit-logs', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        auditLogs.value = response.data;
        filteredLogs.value = response.data;

        const macSet = new Set();
        const userSet = new Set();

        response.data.forEach(log => {
            macSet.add(log.ip_management.ip_address);
            userSet.add(log.user.email);
        });

        ipAddresses.value = Array.from(macSet);
        users.value = Array.from(userSet);
    } catch (error) {
        console.error('Error fetching audit logs:', error);
    }
};

const filterLogs = () => {
    filteredLogs.value = auditLogs.value.filter(log => {
        return (!selectedIpAddress.value || log.ip_management.ip_address === selectedIpAddress.value) &&
            (!selectedUser.value || log.user.email === selectedUser.value);
    });
    sortLogs();
    currentPage.value = 1; // Reset to first page after filtering
};

const sortTable = (key) => {
    if (sortKey.value === key) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortKey.value = key;
        sortDirection.value = 'asc';
    }
    sortLogs();
};

const sortLogs = () => {
    filteredLogs.value.sort((a, b) => {
        let aValue = a;
        let bValue = b;
        if (sortKey.value.includes('.')) {
            const keys = sortKey.value.split('.');
            aValue = keys.reduce((obj, key) => obj[key], a);
            bValue = keys.reduce((obj, key) => obj[key], b);
        } else {
            aValue = a[sortKey.value];
            bValue = b[sortKey.value];
        }

        if (aValue === bValue) return 0;

        if (sortDirection.value === 'asc') {
            return aValue > bValue ? 1 : -1;
        } else {
            return aValue < bValue ? 1 : -1;
        }
    });
};

const changePage = (page) => {
    currentPage.value = page;
};

const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

onMounted(fetchAuditLogs);

const formatDate = (date) => {
    if (!date) return 'N/A';
    const d = new Date(date);
    return isNaN(d) ? 'Invalid Date' : d.toLocaleDateString('en-US', {
        year: 'numeric', month: 'short', day: 'numeric',
        hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
    });
};
</script>
