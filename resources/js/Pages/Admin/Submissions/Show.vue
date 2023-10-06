<template>
    <MainLayout>
        <h1 class="h3 mb-3">Submission Details</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation"><a class="nav-link active" href="#tab-1"
                                        data-bs-toggle="tab" role="tab" aria-selected="true">Overview</a></li>
                                <!-- <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-2"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Panel
                                        Comments</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-3"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Adviser
                                        Comments</a></li> -->
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-4"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                                        Forms</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tab-1" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Research Paper Overview</h4>
                                    <hr>
                                    <h1 class="mb-4">Title: {{ researchPaper.title }}</h1>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h3>Author</h3>
                                                <ul class="list-unstyled">
                                                    <li>{{ researchPaper.author.name }} - {{ researchPaper.author.degree_type }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h3>Adviser</h3>
                                                <ul class="list-unstyled">
                                                    <li>{{ researchPaper.adviser.name }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <h3>Panel Members</h3>
                                                <ul v-if="researchPaper.panel_members.length > 0" class="list-unstyled">
                                                    <li v-for="panel in researchPaper.panel_members" :key="panel.id">{{ panel.name
                                                    }}</li>
                                                </ul>
                                                <p v-else>No panels assigned</p>
                                                <br>
                                                <div class="container">
                                                    <form @submit.prevent="addPanelMembers">
                                                        <div v-for="index in (researchPaper.author.degree_type === 'masters' ? 4 : 5)"
                                                            :key="index" class="mb-3 row">
                                                            <label for="inputName" class="col-4 col-form-label">Panel Member #
                                                                {{ index }}</label>
                                                            <div class="col-6">
                                                                <select class="form-select mb-3" v-model="form.panels[index - 1]">
                                                                    <option selected="" disabled>Open this select menu</option>
                                                                    <option v-for="panel in panelMembers" :key="panel.id" :value="panel.id">{{ panel.name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div v-if="form.errors.panels" class="text-danger">{{ form.errors.panels }}</div>
                                                        <button class="btn um-button">Save Changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h3>Status</h3>
                                                <ul class="list-unstyled">
                                                    <li>{{researchPaper.status}}</li>
                                                </ul>
                                            </div>
                                            <div class="mb-4">
                                                <h3>For Scheduling</h3>
                                                <ul class="list-unstyled">
                                                    <li>{{researchPaper.for_scheduling}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <h1>{{ researchPaper }}</h1> -->
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { useForm } from '@inertiajs/vue3'
import { useToast } from "vue-toastification";
const toast = useToast();


const form = useForm({
  panels: [],
})

const { researchPaper, panelMemberComments, adviserComments, panelMembers } = defineProps({
    researchPaper: Object,
    panelMemberComments: Object,
    adviserComments: Object,
    panelMembers: Object
})

const addPanelMembers = () =>{
    form.post(`/admin/submissions/${researchPaper.id}/add-panel-members`,{
        onSuccess: () => {
            toast.success("Panel Members Added");
        }, onError: (err) => {
            console.log(err)
            toast.error("Error Adding Panel Members");
        }})
}
</script>