<template>
    <div class="container px-4 py-4 mx-auto">
        <div class="flex justify-end mb-4">
            <button @click="createRow" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                Create New
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="w-full text-white bg-gray-800">
                        <th v-for="(header, index) in headers" :key="index" class="px-4 py-2 text-left">{{
                            formatHeader(header) }}</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, rowIndex) in data" :key="rowIndex" class="text-gray-700">
                        <td v-for="(value, key) in row" :key="key" class="px-4 py-2 text-left border">{{ value }}</td>
                        <td class="px-4 py-2 text-left border">
                            <button @click="editRow(row)"
                                class="px-2 py-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                Edit
                            </button>
                            <button @click="deleteRow(row)"
                                class="px-2 py-1 font-bold text-white bg-red-500 rounded hover:bg-red-700">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(['create', 'update', 'delete']);

const headers = ref([]);

watch(
    () => props.data,
    (newValue) => {
        if (newValue.length > 0) {
            headers.value = Object.keys(newValue[0]);
        }
    },
    { immediate: true }
);

const createRow = () => {
    const newRow = {};
    headers.value.forEach((header) => {
        newRow[header] = '';
    });
    emit('create', newRow);
};

const editRow = (row) => {
    emit('update', row);
};

const deleteRow = (row) => {
    emit('delete', row);
};

const formatHeader = (header) => {
    return header
        .split('_')
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
};
</script>
