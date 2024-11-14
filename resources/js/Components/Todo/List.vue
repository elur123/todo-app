<template>
    <div v-if="data.length > 0">
        <transition-group name="todo-list" tag="ul" class="space-y-2">
            <li
                v-for="todo in data"
                :key="todo.id"
                class="bg-gray-50 rounded-md p-4 flex items-center justify-between transition duration-150 ease-in-out hover:bg-gray-100 dark:bg-zinc-500 dark:text-white group"
            >
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        :id="'todo-' + todo.id"
                        v-model="todo.status"
                        @change="emit('updateStatus', todo)"
                        class="form-checkbox h-5 w-5 text-red-500 rounded border-gray-300 focus:ring-red-500 transition duration-150 ease-in-out"
                    />
                    <label
                        :for="'todo-' + todo.id"
                        class="ml-3 text-gray-800 flex flex-col dark:text-white dark:group-hover:text-black"
                        :class="{
                            'line-through text-gray-500': todo.status,
                        }"
                    >
                        <span>{{ todo.title }}</span>
                        <span class="text-sm">{{ todo.description }}</span>
                        <span class="text-xs text-gray-400">{{
                            todo.created_at
                        }}</span>
                    </label>
                </div>
                <div class="flex items-center gap-2">
                    <button
                        @click="emit('selectToUpdate', todo)"
                        class="text-blue-500 hover:text-blue-600 focus:outline-none transition duration-150 ease-in-out"
                    >
                        <PencilSquareIcon class="w-5 h-5" />
                    </button>
                    <button
                        @click="emit('removeTodo', todo.id)"
                        class="text-red-500 hover:text-red-600 focus:outline-none transition duration-150 ease-in-out"
                    >
                        <XMarkIcon class="w-5 h-5" />
                    </button>
                </div>
            </li>
        </transition-group>
    </div>

    <div v-else class="text-center py-8">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-16 w-16 text-gray-400 mx-auto mb-4"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
            />
        </svg>
        <p class="text-gray-600 text-lg">Your todo list is empty</p>
        <p class="text-gray-500 mt-2">{{ filter != 'completed' ? 'Add a new task to get started!' : 'Update your task status.' }}</p>
    </div>
</template>

<script setup>
import { XMarkIcon, PencilSquareIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
    data: Array,
    filter: String
});

const emit = defineEmits(["selectToUpdate", "removeTodo", "updateStatus"]);
</script>
