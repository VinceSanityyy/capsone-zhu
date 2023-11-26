<template>
    <MainLayout>
        <h1 class="h3 mb-3">Announcement Panel</h1>
        <div class="row">
            <div class="col-12 text-end"> <!-- Use "text-end" class to align to the right -->
                <Link href="/admin/announcements/create" class="btn um-button mb-3">Add Announcement</Link>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <DataTable class="display" ref="table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Created By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="announcement in announcements" :key="announcement.id">
                                        <td>{{ announcement.title}}</td>
                                        <td>{{ announcement.content }}</td>
                                        <td>{{ announcement.user.name }}</td>
                                        <td>
                                            <Link :href="`/wala pa`" class="btn btn-sm um-button">View</Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </DataTable>
                    </div>
                </div>
            </div>
        </div>

    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';
import DataTable from 'datatables.net-vue3';

const { announcements } = defineProps({
    announcements: Object
})
</script>