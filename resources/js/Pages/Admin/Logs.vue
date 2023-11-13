<template>
    <MainLayout>
        <h1 class="h3 mb-3">Admin account logs</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <DataTable class="display" ref="table">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="log in logs" :key="log.id">
                                        <td>{{ log.user.name}}</td>
                                        <td>{{ log.action }}</td>
                                        <!-- <td>{{ user.email }}</td> -->
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


const props = defineProps({
    logs: Object
})

</script>

<style>
@import 'datatables.net-dt';
</style>