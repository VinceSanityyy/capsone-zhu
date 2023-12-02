<template>
    <MainLayout>
        <h1 class="h3 mb-3" style = "color:white;">Archived Papers</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <DataTable class="display" ref="table" id="example">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Name</th>
                                        <th>Degree Type</th>
                                        <th>Status</th>
                                        <th>Adviser</th>
                                        <th>Program</th>
                                        <th>Panels</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="submission in papers" :key="submission.id">
                                        <td>{{ submission.title }}</td>
                                        <td>{{ submission.author.name }}</td>
                                        <td>{{ submission.author.degree_type.toUpperCase() }}</td>
                                        <td><span class="badge bg-black">Archived</span></td>
                                        <td>{{ submission.adviser.name }}</td>
                                        <td>{{ submission.author.course.name }}</td>
                                        <td>{{ submission.pannels }}</td>
                                        <td>
                                            <a class="btn um-button btn-sm" target="_blank" :href="submission.document">View Paper</a>
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
import DataTable from 'datatables.net-vue3';
import { defineProps, ref, onMounted, computed, reactive, toRef, nextTick } from 'vue';

const props = defineProps({
    papers: Object
})
</script>

<style scoped>
@import 'datatables.net-dt';
</style>