<template>
  <MainLayout>
    <h1 class="h3 mb-3" style = "color:white;"><strong></strong> Papers/Students Under Evaluation</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Student List
                        </h5>
                        <div class="card-body">
                            <DataTable class="display" ref="table">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Title</th>
                                        <th>Adviser</th>
                                        <th>Status</th>
                                        <th>For Scheduling</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="paper in assignedPapers" :key="paper.id">
                                        <td>{{ paper.author.name }}</td>
                                        <td>{{ paper.title }}</td>
                                        <td>{{ paper.adviser.name }}</td>
                                        <td>{{ paper.status }}</td>
                                        <td>{{ paper.for_scheduling }}</td>
                                        <td>
                                            <Link :href="`/panel/panelled-papers/${paper.id}/show`" class="btn btn-sm um-button">View</Link>
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
import { Link, router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue';
import DataTable from 'datatables.net-vue3';

import { usePage } from '@inertiajs/vue3'

const {assignedPapers} = defineProps({
    assignedPapers: Object
})

</script>

<style>
@import 'datatables.net-dt';
</style>