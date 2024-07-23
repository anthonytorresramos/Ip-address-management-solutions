<!-- resources/js/CustomComponents/JsTable.vue -->
<template>
    <div class="container p-4 mx-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border-b">Mac Address</th>
                    <th class="px-4 py-2 text-left border-b">Label</th>
                    <th class="px-4 py-2 text-left border-b">User Email</th>
                    <th class="px-4 py-2 text-left border-b">Created At</th>
                    <th class="px-4 py-2 text-left border-b">Updated At</th>
                    <th class="px-4 py-2 text-left border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in data" :key="index">
                    <td class="px-4 py-2 text-left border-b">{{ row.mac_address }}</td>
                    <td class="px-4 py-2 text-left border-b">{{ row.label || '- not set -' }}</td>
                    <td class="px-4 py-2 text-left border-b">{{ row.user.email }}</td>
                    <td class="px-4 py-2 text-left border-b">{{ formatDate(row.created_at) }}</td>
                    <td class="px-4 py-2 text-left border-b">{{ formatDate(row.updated_at) }}</td>
                    <td class="px-4 py-2 text-left border-b">
                        <button @click="$emit('update', row)"
                            class="px-2 py-1 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
});

const formatDate = (date) => {
    if (!date) return 'N/A';
    const d = new Date(date);
    return isNaN(d) ? 'Invalid Date' : d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
};
</script>
