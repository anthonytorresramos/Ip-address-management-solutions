<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center" v-if="visible">
        <div class="fixed inset-0 bg-gray-800 opacity-75"></div>
        <div class="z-50 w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl">{{ title }}</h2>
                <button @click="cancel" class="text-gray-600 hover:text-gray-800">&times;</button>
            </div>
            <div class="mt-4">
                <form @submit.prevent="confirm">
                    <div v-for="(value, key) in formData" :key="key" class="mb-4">
                        <label :for="key" class="block text-sm font-medium text-gray-700">{{ key }}</label>
                        <input v-model="formData[key]" :id="key" type="text"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm" />
                    </div>
                    <div class="flex justify-end mt-6">
                        <button @click="cancel" type="button"
                            class="px-4 py-2 mr-2 font-bold text-white bg-gray-500 rounded hover:bg-gray-700">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">{{ confirmText
                            }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    visible: {
        type: Boolean,
        required: true,
    },
    title: {
        type: String,
        default: '',
    },
    confirmText: {
        type: String,
        default: 'Confirm',
    },
    formData: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['cancel', 'confirm']);

const cancel = () => {
    emit('cancel');
};

const confirm = () => {
    emit('confirm', formData);
};
</script>
