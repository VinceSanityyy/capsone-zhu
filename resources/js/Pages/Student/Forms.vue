<template>
    <MainLayout>
        <h1 class="h3 mb-3"><strong></strong>Downloadable Forms</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            List of Forms
                        </h5>
                    </div>
                    <div class="card-body">
                        <DataTable class="display" ref="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="form in forms" :key="form.name">
                                    <td>{{ form.name }}</td>
                                    <td>
                                        <a :href=form.url class="btn um-button" target="_blank">Download</a>
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
import { ref } from 'vue';
import DataTable from 'datatables.net-vue3';


//static 
const forms = ref([
    {
        name: 'Endorsement Form',
        url: '/forms/endorsement_for_defense.pdf'
    },
    {
        name: 'Instruction for UMERC',
        url: '/forms/instruction_for_umerc.pdf'
    },
    {
        name: 'Library Visit',
        url: '/forms/library_visit.pdf'
    },
    {
        name: 'Instrument of Validation',
        url: '/forms/instrument_of_validation.pdf'
    },
    {
        name: 'Qualitative Minutes',
        url: '/forms/qualitative_minutes.docx'
    },
    {
        name: 'Quantitative Minutes',
        url: '/forms/quantitative_minutes.docx'
    },
    {
        name: 'Revised Guide',
        url: '/forms/revised_guide.pdf'
    }
]);

</script>

<style>
@import 'datatables.net-dt';
</style>