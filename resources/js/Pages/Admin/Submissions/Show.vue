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
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-2"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Panel
                                        Comments</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-3"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Adviser
                                        Comments</a></li>
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

                                    <div class="mb-4">
                                        <h3>Adviser</h3>
                                        <ul class="list-unstyled">
                                            <li>{{ researchPaper.adviser.name }}</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h3>Panel Members</h3>
                                        <ul class="list-unstyled">
                                            <li v-for="panel in researchPaper.panel_members" :key="panel.id">{{ panel.name
                                            }}</li>
                                        </ul>
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
                                                    on the study {{ researchPaper.title }}</strong><br>
                                                <small class="text-muted">{{ comment.date_created }}</small>

                                                <div class="border text-sm text-muted p-2 mt-1">
                                                    {{ comment.comment }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-3" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Adviser Comments</h4>
                                    <hr>
                                    <div v-for="comment in adviserComments" :key="comment.id" class="card-body h-100">
                                        <hr>
                                        <div class="d-flex align-items-start">
                                            <img src="https://edukasyon-production.s3.amazonaws.com/uploads/school/avatar/17455/red.jpg"
                                                width="36" height="36" class="rounded-circle me-2" alt="Charles Hall">
                                            <div class="flex-grow-1">
                                                <small class="float-end text-navy">30m ago</small>
                                                <strong>{{ comment.user.name }}</strong> wrote a comment <strong>
                                                    on the study {{ researchPaper.title }}</strong><br>
                                                <small class="text-muted">{{ comment.date_created }}</small>

                                                <div class="border text-sm text-muted p-2 mt-1">
                                                    {{ comment.comment }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-4" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Forms Submitted</h4>
                                    <hr>
                                    <ul>
                                        <li>
                                            <button class="btn um-button">
                                                Endorsement Form &nbsp;
                                                <i class="bi bi-cloud-arrow-down"></i>
                                            </button>
                                        </li>
                                        <br>
                                        <li>
                                            <button class="btn um-button">
                                                Other Form &nbsp;
                                                <i class="bi bi-cloud-arrow-down"></i>
                                            </button>
                                        </li>
                                        <br>
                                        <li>
                                            <button class="btn um-button">
                                                Receipt Form &nbsp;
                                                <i class="bi bi-cloud-arrow-down"></i>
                                            </button>

                                        </li>
                                    </ul>
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

const { researchPaper, panelMemberComments, adviserComments } = defineProps({
    researchPaper: Object,
    panelMemberComments: Object,
    adviserComments: Object
})
</script>