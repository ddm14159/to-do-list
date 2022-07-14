<script setup>
import AddForm from "../Components/AddForm.vue";
import { Head, Link } from '@inertiajs/inertia-vue3';
import ListView from "../Components/ListView.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    task: String,
})
let name = '';
let data;
let tasks = [];

function getTasks() {
    axios.get('tasks')
        .then(function(response) {
           tasks = response.data;
           console.log(tasks);
        })
        .catch(function (error) {
        console.log(error);
    });
}

function addTask() {
    if (this.name == '') {
        return
    }
    axios.post('tasks', {
        name: this.name
    })
        .then(response => {
            if (response.status == 201) {
                name = '';
                getTasks();
            }
        })
        .catch(error => {
            console.log(error);
        });
    getTasks();
}
</script>

<template>
    <Head title="Welcome" />

    <div>Form</div>
    <div class="mb-3">
        <input v-model="name" type="text" class="form-control">
        <button @click="addTask()" class="btn btn-primary">Добавить</button>
    </div>

    <div>List View</div>
    {{ getTasks() }}
    {{ tasks }}
    <li v-for="(item, index) in tasks">
        <button @click="">{{ item.id }} - {{ item.name }}</button>
    </li>
</template>

<style scoped>

</style>
