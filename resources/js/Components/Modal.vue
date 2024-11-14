<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="emit('close')" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                        >
                            <DialogTitle
                                as="h3"
                                class="text-lg font-medium leading-6 text-gray-900"
                            >
                                {{ title ?? "New Task" }}
                            </DialogTitle>

                            <div class="mt-2 space-y-4">
                                <div space-y-2>
                                    <label class="text-black text-gray-600"
                                        >Title</label
                                    >
                                    <input
                                        v-model="formRequest.title"
                                        class="w-full flex-grow px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black"
                                        type="text"
                                    />
                                    <InputError
                                        :message="
                                            errors?.title
                                                ? errors?.title[0]
                                                : ''
                                        "
                                    />
                                </div>

                                <div space-y-2>
                                    <label class="text-black text-gray-600"
                                        >Description</label
                                    >
                                    <textarea
                                        v-model="formRequest.description"
                                        class="w-full flex-grow px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black"
                                    ></textarea>
                                    <InputError
                                        :message="
                                            errors?.description
                                                ? errors?.description[0]
                                                : ''
                                        "
                                    />
                                </div>
                            </div>

                            <div class="mt-4 flex items-center gap-2">
                                <button
                                    type="button"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                    @click="emit('submit', formRequest)"
                                >
                                    Submit
                                </button>
                                <button
                                    type="button"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-gray-100 px-4 py-2 text-sm font-medium text-gray-900"
                                    @click="emit('close')"
                                >
                                    Close
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref, watch } from "vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    isOpen: Boolean,
    title: String,
    errors: Object,
    todo: Object,
});

const emit = defineEmits(["submit", "close"]);

const formRequest = ref({
    title: "",
    description: "",
});

watch(
    () => props.todo,
    function (newValue) {
        formRequest.value = {
            title: newValue.title,
            description: newValue.description,
        };
    }
);
</script>
