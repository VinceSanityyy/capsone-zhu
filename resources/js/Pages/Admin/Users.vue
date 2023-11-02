<template>
    <MainLayout>
        <th>Program</th>
        
        <h1 class="h3 mb-3">User Management</h1>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <DataTable class="display" ref="table">
                                <thead>
                                    <tr>
                                        <th>Id Number</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role(s)</th>
                                        <th>Program</th>
                                        <th>School Year</th>
                                        <th>Subject Code</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users" :key="user.id">
                                        <td>{{ user.id_number || 'N/A' }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.current_roles }}</td>
                                        <!-- <td>{{ user.course.name }}</td> -->
                                        <td>{{ user.course ? user.course.name : 'N/A' }}</td>
                                        <td>{{ user.school_year || 'N/A'}}</td>
                                        <td>{{ user.subject_code || 'N/A' }}</td>
                                        <td>{{ user.phone_number }}</td>
                                        <td v-html="statusBadge(user)"></td>
                                        <td>
                                            <Link :href="`/admin/users/user/${user.id}/show`" class="btn btn-sm um-button">View</Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </DataTable>
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
import DataTable from 'datatables.net-vue3';


const { users } = defineProps({
    users: Object
})

const statusBadge = (user) => {
    return user.is_active
        ? '<span class="badge rounded-pill text-bg-primary">Approved</span>'
        : '<span class="badge rounded-pill text-bg-danger">Pending</span>';
}

</script>

<style>
@import 'datatables.net-dt';
</style>