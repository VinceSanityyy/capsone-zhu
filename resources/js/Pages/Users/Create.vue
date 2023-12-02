<template>
    <MainLayout>
        <h1 class="h3 mb-3" style = "color:white;">Create new User</h1>
        <div class="row">
            <div class="col-md-3 col-xl-2">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Credentials</h5>
                    </div>

                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account"
                            role="tab" aria-selected="true">
                            Personal Information
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-xl-10">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="account" role="tabpanel">

                        <div class="card">
                            <div class="card-header">

                                <h5 class="card-title mb-0">Personal info</h5>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="form.post('/admin/users/create')">
                                    <div class="row">
                                        <div class="mb-3">
                                            <label class="form-label" for="inputFirstName">Name </label>
                                            <input v-model="form.name" type="text" class="form-control" id="inputFirstName">
                                            <div v-if="form.errors.name" class="text-danger">{{ form.errors.name
                                            }}</div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputEmail4">Email</label>
                                        <input v-model="form.email" type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                        <div v-if="form.errors.email" class="text-danger">{{ form.errors.email
                                            }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputEmail4">Phone Number</label>
                                        <input v-model="form.phone" type="text" class="form-control" id="inputEmail4" placeholder="Email">
                                        <div v-if="form.errors.phone" class="text-danger">{{ form.errors.phone
                                            }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputEmail4">Role</label>
                                        <select v-model="form.role" class="form-control mb-3">
                                            <option :value="role.name" v-for="role in roles" :key="role.id">{{ role.name }}</option>
                                        </select>
                                        <div v-if="form.errors.role" class="text-danger">{{ form.errors.role
                                            }}</div>
                                    </div>
                                    <button type="submit" class="btn um-button" style = "background-color: #e0ba1f;">
                                        Add User
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { defineProps, ref, onMounted, reactive, computed, toRaw } from 'vue';
import { Link, router } from '@inertiajs/vue3'

const { roles } = defineProps({
    roles: Object
})

import { useForm } from '@inertiajs/vue3'
const form = useForm({
  email: null,
  name: null,
  role: null,
  phone: null
})
</script>


<style scoped>
.list-group-item.active {
    background-color: #af2532;
    border-color: #af2532;
    color: white;
    z-index: 2;
}
</style>