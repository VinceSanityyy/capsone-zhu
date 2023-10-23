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

                                    for debugging only: form value => {{ form.comment }}
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
                                    <h4 class="tab-title">Downloadable Forms</h4>
                                    <hr>
                                    <ul>
                                        <li>
                                            <a :href="formUrl" target="_blank" class="btn um-button">
                                                Evaluation Form &nbsp;
                                                <i class="bi bi-cloud-arrow-down"></i>
                                            </a>
                                        </li>
                                        <small>dummy form kay wala pay eval</small>
                                        <br>
                                    </ul>
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
const toast = useToast();

const editor = ClassicEditor;

const { paper, panelMemberComments, adviserComments } = defineProps({
    paper: Object,
    adviserComments: Object,
    panelMemberComments: Object
})

const form = useForm({
    comment: ''
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

const formUrl = ref('/forms/endorsement_for_defense.pdf')


</script>