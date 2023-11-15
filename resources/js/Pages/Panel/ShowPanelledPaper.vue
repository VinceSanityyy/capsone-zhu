<template>
    <MainLayout>
        <h1 class="h3 mb-3"><strong></strong> Panelled Paper</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Research Title details</h5>
                        <h6 class="card-subtitle text-muted">You can add your comments in this section</h6>
                    </div>
                    <div class="card-body">
                        <div class="tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation"><a class="nav-link active" href="#tab-1"
                                        data-bs-toggle="tab" role="tab" aria-selected="true">Overview</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-2"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Panel
                                        Comments</a></li>
                                <!-- <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-3"
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
                                    <h1 class="mb-4">Title: {{ paper.title }}</h1>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h3>Adviser</h3>
                                                <ul class="list-unstyled">
                                                    <li>{{ paper.adviser.name }}</li>
                                                </ul>
                                            </div>
                                            <div class="mb-4">
                                                <h3>Author</h3>
                                                <ul class="list-unstyled">
                                                    <li>{{ paper.author.name }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <h3>Panel Members</h3>
                                                <ul class="list-unstyled">
                                                    <li v-for="panel in paper.panel_members" :key="panel.id">{{ panel.name
                                                    }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab-2" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Panel Comments</h4>
                                    <hr>
                                    <div>
                                        <div v-for="comment in panelMemberComments" :key="comment.id" class="card-body h-100">
                                        <hr>
                                        <div class="d-flex align-items-start">
                                            <img src="https://edukasyon-production.s3.amazonaws.com/uploads/school/avatar/17455/red.jpg"
                                                width="36" height="36" class="rounded-circle me-2" alt="Charles Hall">
                                            <div class="flex-grow-1">
                                                <small class="float-end text-navy">30m ago</small>
                                                <strong>{{ comment.user.name }}</strong> wrote a comment <strong>
                                                    on the study {{ paper.title }}</strong><br>
                                                <small class="text-muted">{{ comment.date_created }}</small>

                                                <div class="border text-sm text-muted p-2 mt-1">
                                                    <div v-html="comment.comment"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="tab-title">Add your comment here</h4>
                                    <form @submit.prevent="handleSubmitComment">
                                        <ckeditor :editor="editor" v-model="form.comment"></ckeditor>
                                        <div v-if="form.errors.comment" class="text-danger">{{ form.errors.comment
                                        }}</div>
                                        <button type="submit" class="btn um-button mt-4 btn-block">Add Comment</button>
                                    </form>
                                    <br><br>
                                        <div class="mb-3 col-md-3">
                                            <form @submit.prevent="handleSubmitEvaluation">
                                                <label for="" class="form-label">Attach evaluation form</label>
                                                <input @input="form.evaluation = $event.target.files[0]" type="file"
                                                    class="form-control um-button" name="" id="" placeholder="" required
                                                    aria-describedby="fileHelpId">
                                                <div id="fileHelpId" class="form-text">Download your evaluation first in the
                                                    next tab</div>
                                                <button type="submit" class="btn um-button">Submit Evaluation</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="tab-pane" id="tab-3" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Adviser's Comments</h4>
                                    <hr>
                                    <div v-for="comment in adviserComments" :key="comment.id" class="card-body h-100">
                                        <div class="card-body h-50">

                                            <hr>
                                            <div class="d-flex align-items-start">
                                                <img src="https://edukasyon-production.s3.amazonaws.com/uploads/school/avatar/17455/red.jpg"
                                                    width="36" height="36" class="rounded-circle me-2" alt="Charles Hall">
                                                <div class="flex-grow-1">
                                                    <small class="float-end text-navy">30m ago</small>
                                                    <strong>{{ comment.user.name }}</strong> wrote a comment <strong>
                                                        on the study {{ paper.title }}</strong><br>
                                                    <small class="text-muted">{{ comment.date_created }}</small>

                                                    <div class="border text-sm text-muted p-2 mt-1">
                                                        <div v-html="comment.comment"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div> -->
                                <div class="tab-pane" id="tab-4" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Forms Attached</h4>
                                    <a :href="formUrl" target="_blank" class="btn um-button float-end">
                                        Evaluation Form &nbsp;
                                        <i class="bi bi-cloud-arrow-down"></i>
                                    </a>

                                    <br>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <DataTable class="display" ref="table">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Stage Attached</th>
                                                        <th>Date Submitted</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="evaluation in attachedEvaluationForms"
                                                        :key="evaluation.id">
                                                        <td>Eval Form</td>
                                                        <td>{{ evaluation.stage_submitted }}</td>
                                                        <td>{{ evaluation.created_at }}</td>
                                                        <td>
                                                            <a :href="evaluation.file_path" class="btn btn-sm um-button"
                                                                target="_blank">Download</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </DataTable>
                                        </div>
                                    </div>
                                </div>
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
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { useToast } from "vue-toastification";
import DataTable from 'datatables.net-vue3';
const toast = useToast();

const editor = ClassicEditor;

const { paper, panelMemberComments, adviserComments, attachedEvaluationForms } = defineProps({
    paper: Object,
    adviserComments: Object,
    panelMemberComments: Object,
    attachedEvaluationForms: Object
})

const form = useForm({
    comment: '',
    evaluation: ''
})

const handleSubmitComment = () => {
    // console.log(form.comment)
    form.post(`/panel/panelled-papers/${paper.id}/comment`, {
        onSuccess: () => {
            toast.success("Comment Added");
            form.comment = '';
        }, onError: (err) => {
            toast.error("Error Adding Comment");
        }
    })
}

const handleSubmitEvaluation = () =>{
    console.log(form)
    form.post(`/panel/panelled-papers/${paper.id}/attach-evaluation`, {
        onSuccess: () => {
            toast.success("Evaluation Added");
            form.reset()
        }, onError: (err) => {
            toast.error("Error Adding Comment");
        }
    })
}

const formUrl = ref('/forms/endorsement_for_defense.pdf')


</script>

<style scoped>@import 'datatables.net-dt';</style>