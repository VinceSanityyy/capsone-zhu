<template>
    <MainLayout>
        <h1 class="h3 mb-3">Profile</h1>
        <div class="row">
            <div class="col-md-3 col-xl-2">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Settings</h5>
                    </div>

                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account"
                            role="tab" aria-selected="true">
                            Personal Information
                        </a>
                        <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab"
                            aria-selected="false" tabindex="-1">
                            Password
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
                                <form @submit.prevent="updateUserInfo">
                                    <div class="row">
                                        <div class="mb-3">
                                            <label class="form-label" for="inputFirstName">Name </label>
                                            <input type="text" class="form-control" id="inputFirstName"
                                                v-model="userDetails.name" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputEmail4">Email</label>
                                        <input type="email" class="form-control" id="inputEmail4" placeholder="Email"
                                            v-model="userDetails.email" disabled>
                                    </div>
                                    <!-- <div class="mb-3">
                                        <label class="form-label" for="inputAddress">Program</label>
                                        <input type="text" class="form-control" id="inputAddress"
                                            v-model="userDetails.course.name ?? ''" disabled>
                                    </div> -->
                                    <div class="mb-3">
                                        <label class="form-label" for="inputAddress">Program</label>
                                        <input type="text" class="form-control" id="inputAddress"
                                            :value="userDetails.course ? userDetails.course.name : ''" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputAddress2">School year</label>
                                        <input type="text" class="form-control" id="inputAddress2"
                                            v-model="userDetails.school_year" disabled>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="inputCity">Subject Code</label>
                                            <input type="text" class="form-control" id="inputCity"
                                                v-model="userDetails.subject_code" disabled>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="inputZip">Phone </label>
                                            <input type="text" class="form-control" id="inputZip"
                                                v-model="userDetails.phone_number" disabled>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="inputZip">Status</label>
                                            <span :class="userDetails.is_active ? 'badge bg-success' : 'badge bg-danger'"
                                                id="inputZip" style="margin-left: 20px">
                                                {{ userDetails.is_active ? 'Approved' : 'Waiting for approval' }}
                                            </span>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="inputCity">Birthday</label>
                                            <input v-model="form.birthday" class="form-control" type="date" name="" id="">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="inputCity">Address</label>
                                            <input type="text" class="form-control" id="inputCity"
                                                v-model="form.address">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="inputCity">Gender</label>
                                            <select v-model="form.gender" class="form-control" name="" id="">
                                                <option value="male"> Male </option>
                                                <option value="female"> Female </option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" @click="handleUser(userDetails)" class="btn um-button"
                                        v-if="userDetails.roles.some(role => role.name === 'admin')">
                                        {{ userDetails.is_active ? 'Deactivate User' : 'Confirm User' }}
                                    </button>

                                    <button type="button" @click="updateUserInfo(userDetails)" class="btn um-button" v-else>
                                        Update User Info
                                    </button>
                                </form>
                            </div>
                        </div>

                        //current user roles (for dbugging)
                        <div v-for="role in userDetails.roles" :key="role.id">
                            {{ role.name }}
                        </div>

                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Password</h5>

                                <form @submit.prevent="handleSubmit">
                                    <div class="mb-3">
                                        <label class="form-label" for="inputPasswordCurrent">Current password</label>
                                        <input v-model="form.current_password" type="password" class="form-control"
                                            id="inputPasswordCurrent">
                                        <div v-if="form.errors.current_password" class="text-danger">{{
                                            form.errors.current_password
                                        }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputPasswordNew">New password</label>
                                        <input v-model="form.new_password" type="password" class="form-control"
                                            id="inputPasswordNew">
                                        <div class="text-muted">Make sure your password is strong and easy to remember.
                                        </div>
                                        <div v-if="form.errors.new_password" class="text-danger">{{ form.errors.new_password
                                        }}</div>
                                    </div>

                                    <button type="submit" class="btn um-button">Save changes</button>
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
import { useToast } from "vue-toastification";
const toast = useToast();

const { userDetails } = defineProps({
    userDetails: Object
})

import { useForm } from '@inertiajs/vue3'
const form = useForm({
    current_password: null,
    new_password: null,
    address: null,
    gender: null,
    birthday: null
})

const handleSubmit = async () => {
    try {
        await form.post('/profile/change-password', {
            onSuccess: () => {
                toast.success('Password changed successfully.');
                toast.set('notifier', 'position', 'top-right');
            },
            onError: (errors) => {
                console.error(errors); // Log the errors for debugging
                toast.set('notifier', 'position', 'top-right');
            },
        });
    } catch (error) {
        console.error(error); // Log the error for debugging
        toast.error('An error occurred while changing the password.');
    }
};

const updateUserInfo = async () => {
    try {
        await form.put('/profile/update', {
            onSuccess: () => {
                toast.success('Information updated successfully.');
                toast.set('notifier', 'position', 'top-right');
            },
            onError: (errors) => {
                console.error(errors); // Log the errors for debugging
                toast.set('notifier', 'position', 'top-right');
            },
        });
    } catch (error) {
        console.error(error); // Log the error for debugging
        toast.error('Error');
    }
}

</script>


<style scoped>
.list-group-item.active {
    background-color: #af2532;
    border-color: #af2532;
    color: white;
    z-index: 2;
}
</style>