<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    tasks: Array,
    task: String,
})
let name = ''
function addItem() {
    if (this.name == '') {
        return
    }
    console.log(this.name)
    axios.post('tasks', {
        name: this.name
    })
        .then(response => {
            if (response.status == 200) {
                this.name = '';
                console.log(this.name);
            }
        })
        .catch(error => {
            console.log(error);
        })
}
</script>

<template>
    <div>Form</div>
    <div class="mb-3">
        <input v-model="name" type="text" class="form-control">
        <button @click="addItem()" type="submit" class="btn btn-primary">Submit</button>
    </div>
</template>

<style scoped>

</style>
