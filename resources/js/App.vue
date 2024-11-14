<template>
    <main class="mt-6">
        <div
            ref="todoContainer"
            class="max-h-[520px] overflow-hidden overflow-y-auto relative rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] md:row-span-3 lg:p-8 dark:bg-zinc-900 dark:ring-zinc-800"
        >
            <Header @showCreate="showCreate" />

            <Filter @changeFilter="(status) => (pageParams.status = status)" />

            <List
                :data="todos.data"
                :filter="pageParams.status"
                @selectToUpdate="selectToUpdate"
                @removeTodo="removeTodo"
                @updateStatus="updateStatus"
            />
        </div>
        <Modal
            :title="modalTitle"
            :isOpen="isOpenModal"
            :errors="errors"
            :todo="todo"
            @submit="submit"
            @close="isOpenModal = false"
        />
    </main>
</template>

<script setup>
// Packages Import
import { ref, onMounted, onBeforeUnmount, watch } from "vue";

// Files Import
import Modal from "@/Components/Modal.vue";
import Header from "@/Components/Todo/Header.vue";
import Filter from "@/Components/Todo/Filter.vue";
import List from "@/Components/Todo/List.vue";

// Variables
const todos = ref({
    data: [],
    links: null,
    meta: null,
});
const todo = ref({
    id: null,
    title: "",
    description: "",
    status: "",
});
const errors = ref(null);
const pageParams = ref({
    perPage: 6,
    page: 1,
    status: "all",
});
const isOpenModal = ref(false);
const modalTitle = ref("New Todo");
const todoContainer = ref(null);
const isLoading = ref(false);
const baseUrl = ref("/api/v1/todos");

// Functions
const getTodoList = () => {
    const url = `${baseUrl.value}?page=${pageParams.value.page}&per_page=${pageParams.value.perPage}&status=${pageParams.value.status}`;
    axios
        .get(url)
        .then((res) => {
            todos.value = {
                data: res.data.data,
                links: res.data.links,
                meta: res.data.meta,
            };
        })
        .catch((err) => {});
};

const showCreate = () => {
    isOpenModal.value = "";
    errors.value = null;
    modalTitle.value = "New Todo";
    todo.value = {
        id: null,
        title: "",
        description: "",
        status: "",
    };
};

const submit = (request) => {
    if (todo.value.id) {
        updateTodo(request);
    } else {
        createTodo(request);
    }
};

const createTodo = (request) => {
    const url = `${baseUrl.value}`;
    axios
        .post(url, request)
        .then((res) => {
            if (pageParams.value.status != "completed") {
                todos.value.data.unshift(res.data.data);
            }
            isOpenModal.value = false;
        })
        .catch((err) => {
            errors.value = err.response.data.errors;
        });
};

const selectToUpdate = (data) => {
    todo.value = data;
    errors.value = null;
    modalTitle.value = "Edit Todo";
    isOpenModal.value = true;
};

const updateTodo = (request) => {
    const url = `${baseUrl.value}/${todo.value.id}`;
    axios
        .put(url, request)
        .then((res) => {
            const index = todos.value.data.indexOf(
                todos.value.data.find((e) => e.id == todo.value.id)
            );
            todos.value.data[index] = res.data.data;

            todo.value = {
                id: null,
                title: "",
                description: "",
                status: "",
            };
            errors.value = null;
            isOpenModal.value = false;
        })
        .catch((err) => {
            errors.value = err.response.data.errors;
        });
};

const updateStatus = (todo) => {
    const url = `${baseUrl.value}/${todo.id}`;
    axios
        .put(url, todo)
        .then((res) => {})
        .catch((err) => {
            errors.value = err.response.data.errors;
        });
};

const removeTodo = (id) => {
    const url = `${baseUrl.value}/${id}`;
    axios
        .delete(url)
        .then((res) => {
            todos.value.data = todos.value.data.filter((e) => e.id != id);

            if (todos.value.data.length <= pageParams.value.perPage / 2) {
                getTodoList();
            }
        })
        .catch((err) => {
            errors.value = err.response.data.errors;
        });
};

const showMore = () => {
    if (
        pageParams.value.page >= todos.value.meta.last_page ||
        isLoading.value
    ) {
        return;
    }

    isLoading.value = true; // Set loading flag
    pageParams.value.page++;
    const url = `${baseUrl.value}?page=${pageParams.value.page}&per_page=${pageParams.value.perPage}`;
    axios
        .get(url)
        .then((res) => {
            const combinedData = [...todos.value.data, ...res.data.data];
            const uniqueData = combinedData.filter(
                (todo, index, self) =>
                    index === self.findIndex((t) => t.id === todo.id)
            );

            todos.value = {
                ...todos.value,
                data: uniqueData,
                links: res.data.links,
                meta: res.data.meta,
            };
        })
        .catch((err) => {
            // Handle error
        })
        .finally(() => {
            isLoading.value = false; // Reset loading flag after request completes
        });
};

const handleScroll = () => {
    if (todoContainer.value) {
        const { scrollTop, scrollHeight, clientHeight } = todoContainer.value;
        // Check if scrolled to the bottom
        if (scrollTop + clientHeight >= scrollHeight - 10) {
            showMore();
        }
    }
};

// Lifecycle functions
watch(
    () => pageParams.value.status,
    function (newValue) {
        pageParams.value.page = 1;
        getTodoList();
    }
);

onMounted(() => {
    getTodoList();
    if (todoContainer.value) {
        todoContainer.value.addEventListener("scroll", handleScroll);
    }
});

onBeforeUnmount(() => {
    if (todoContainer.value) {
        todoContainer.value.removeEventListener("scroll", handleScroll);
    }
});
</script>

<style scoped>
.todo-list-enter-active,
.todo-list-leave-active {
    transition: all 0.5s ease;
}
.todo-list-enter-from,
.todo-list-leave-to {
    opacity: 0;
    transform: translateY(30px);
}
</style>
