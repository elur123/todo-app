<template>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-2xl font-bold text-black dark:text-white">Todo List</h3>
        <button
            class="px-4 py-2 rounded-lg bg-white flex items-center gap-2 text-black border-2 border-blue-500 dark:bg-blue-500 dark:text-white dark:hover:bg-white dark:hover:text-black"
            @click="emit('showCreate')"
        >
            <PlusIcon class="w-6 h-6" />
            New Todo
        </button>
    </div>
</template>
<script setup>
import { PlusIcon } from "@heroicons/vue/24/solid";
const emit = defineEmits(['showCreate'])
</script>
