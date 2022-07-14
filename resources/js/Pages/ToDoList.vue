<template>
    <div class="container py-3">
        <header>
            <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                <h1 class="display-4 fw-normal">ToDo List</h1>
            </div>
        </header>

        <main>
            <div class="row row-cols-1 row-cols-md-2 mb-3 text-center">
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h3 class="my-0 fw-normal">Tasks ({{ normal.length}})</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li
                                    v-if="normal.length > 0"
                                    v-for="task in normal" :key="task.id"
                                    class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button   @click.prevent="isShowDropdown[task.id] = !isShowDropdown[task.id]">
                                            <div v-bind:class="[task.completed ? underline : '']">
                                                {{ task.name }}
                                            </div>
                                        </button>
                                    </div>
                                    <div class="row bg-light" v-if="isShowDropdown[task.id]">
                                        <div class="col d-flex justify-content-between align-items-center">
                                            <a href="#" @click.prevent="destroy(task)">
                                                 Delete
                                            </a>
                                        </div>
                                        <div class="col d-flex justify-content-between align-items-center">
                                            <a href="#" @click.prevent="changeUrgency(task)">
                                                Urgent
                                            </a>
                                        </div>
                                        <div class="col d-flex justify-content-between align-items-center">
                                            <a href="#" @click.prevent="changeCompletion(task)">
                                                Complete
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <section id="add-todo-form" class="my-3">
                                <form>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <input
                                            v-model="newTask.name"
                                            v-on:keyup.enter="addTask"
                                            placeholder="Enter task name"
                                            type="text" class="form-control mr-3">
                                        <button @click.prevent="addTask" class="btn btn-primary">Add</button>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h3 class="my-0 fw-normal">Urgent Tasks  <span v-bind:class="[urgent.length >=3 ? alarm : '']">({{ urgent.length}})</span></h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li
                                    v-if="urgent.length > 0"
                                    v-for="task in urgent" :key="task.id"
                                    class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button   @click.prevent="isShowDropdown[task.id] = !isShowDropdown[task.id]">
                                            <div v-bind:class="[task.completed ? underline : '']">
                                                {{ task.name }}
                                            </div>
                                        </button>
                                    </div>
                                    <div class="row bg-light" v-if="isShowDropdown[task.id]">
                                        <div class="col d-flex justify-content-between align-items-center">
                                            <a href="#" @click.prevent="destroy(task)">
                                                Delete
                                            </a>
                                        </div>
                                        <div class="col d-flex justify-content-between align-items-center">
                                            <a href="#" @click.prevent="changeUrgency(task)">
                                                Normal
                                            </a>
                                        </div>
                                        <div class="col d-flex justify-content-between align-items-center">
                                            <a href="#" @click.prevent="changeCompletion(task)">
                                                Complete
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    name: 'TodoList',
    data() {
        return {
            underline: 'underline',
            alarm : 'alarm',
            normal: [],
            urgent: [],
            isShowDropdown: [],
            newTask: {
                name: undefined
            }
        }
    },
    mounted() {
        this.load();
    },
    methods: {
        load() {
            axios.get('/tasks')
                .then((response) => {
                    let tasks = response.data;
                    this.urgent = [];
                    this.normal = [];
                    this.isShowDropdown = [];
                    for(let i = 0; i < tasks.length; i++) {
                        if (tasks[i].urgent) {
                            this.urgent.push(tasks[i]);
                        } else {
                            this.normal.push(tasks[i]);
                        }
                        this.isShowDropdown[tasks[i].id] = false;
                    }
                    this.newTask.name = undefined;
                })
                .catch((error) => {
                    console.log(error.message);
                })
        },
        addTask() {
            axios.post('/tasks', this.newTask)
                .then((response) => {
                    this.load();
                    this.newTask.name = undefined;
                })
                .catch((error) => {
                    console.log(error.message);
                })
        },
        changeUrgency(task) {
            axios.patch(`/tasks/${task.id}`, {urgent: !task.urgent})
                .then((response) => {
                    this.load();
                })
                .catch((error) => {
                    console.log(error.message);
                })
        },
        changeCompletion(task) {
            axios.patch(`/tasks/${task.id}`, {completed: !task.completed})
                .then((response) => {
                    this.load();
                })
                .catch((error) => {
                    console.log(error.message);
                })
        },
        destroy(task) {
            axios.delete(`/tasks/${task.id}`)
                .then((response) => {
                    this.load();
                })
                .catch((error) => {
                    console.log(error.message);
                })
        }
    }
}
</script>

<style>
h3 {
    font-size: 20pt;
}
.underline {
    text-decoration: line-through;
}
.alarm {
    color: red;
}
</style>
