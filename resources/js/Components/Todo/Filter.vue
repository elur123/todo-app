<template>
    <div class="flex items-center gap-4 mb-4">
        <div class="flex items-center">
            <input
                type="radio"
                id="filter-status-all"
                value="all"
                v-model="status"
                class="form-checkbox h-5 w-5 text-blue-500 rounded border-gray-300 focus:ring-blue-500 transition duration-150 ease-in-out"
            />
            <label
                for="filter-status-all"
                class="ml-3 text-gray-800 flex flex-col dark:text-white dark:group-hover:text-black"
            >
                All
            </label>
        </div>

        <div class="flex items-center">
            <input
                type="radio"
                id="filter-status-pending"
                value="pending"
                v-model="status"
                class="form-checkbox h-5 w-5 text-red-500 rounded border-gray-300 focus:ring-red-500 transition duration-150 ease-in-out"
            />
            <label
                for="filter-status-pending"
                class="ml-3 text-gray-800 flex flex-col dark:text-white dark:group-hover:text-black"
            >
                Pending
            </label>
        </div>

        <div class="flex items-center">
            <input
                type="radio"
                id="filter-status-completed"
                value="completed"
                v-model="status"
                class="form-checkbox h-5 w-5 text-red-500 rounded border-gray-300 focus:ring-red-500 transition duration-150 ease-in-out"
            />
            <label
                for="filter-status-completed"
                class="ml-3 text-gray-800 flex flex-col dark:text-white dark:group-hover:text-black"
            >
                Completed
            </label>
        </div>
    </div>
</template>
<script setup>
import { ref, watch } from 'vue';

const emit = defineEmits(['changeFilter']);

const status = ref('all');

watch(() => status.value, function(newValue) {
    emit('changeFilter', newValue);
})
</script>
