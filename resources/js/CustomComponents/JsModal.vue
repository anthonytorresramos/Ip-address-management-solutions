<!-- resources/js/CustomComponents/JsModal.vue -->
<template>
    <div class="fixed inset-0 flex items-center justify-center z-50" v-if="visible">
        <div class="fixed inset-0 bg-gray-800 opacity-75"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 z-50 max-w-lg w-full">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl">{{ title }}</h2>
                <button @click="cancel" class="text-gray-600 hover:text-gray-800">&times;</button>
            </div>
            <div class="mt-4">
                <form @submit.prevent="confirm">
                    <div class="mb-4">
                        <label for="ip_address" class="block text-sm font-medium text-gray-700">Ip Address</label>
                        <input v-model="formData.ip_address" id="ip_address" type="text"
                            class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            :class="{ 'bg-gray-200 cursor-not-allowed': isUpdate }" :disabled="isUpdate" />
                        <div v-if="errors.ip_address" class="text-red-600 text-sm">{{ errors.ip_address }}</div>
                    </div>
                    <div class="mb-4">
                        <label for="label" class="block text-sm font-medium text-gray-700">Label</label>
                        <input v-model="formData.label" id="label" type="text"
                            class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        <div v-if="errors.label" class="text-red-600 text-sm">{{ errors.label }}</div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button @click="cancel" type="button"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ confirmText
                            }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive } from 'vue';

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
    isUpdate: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(['cancel', 'confirm']);

const errors = reactive({ ip_address: null, label: null });

const cancel = () => {
    emit('cancel');
    clearErrors();
};

const confirm = () => {
    emit('confirm', { ip_address: props.formData.ip_address, label: props.formData.label });
};

const clearErrors = () => {
    errors.ip_address = null;
    errors.label = null;
};

defineExpose({ errors, clearErrors });
</script>
