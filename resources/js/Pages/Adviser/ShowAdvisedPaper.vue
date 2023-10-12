<template>
    <MainLayout>
        <h1 class="h3 mb-3"><strong></strong> Advised Paper</h1>
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
                                <!-- <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-2"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Panel
                                        Comments</a></li> -->
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
                                    <h1 class="mb-4">Title: {{ paper.title }}</h1>

                                    <div class="mb-4">
                                        <h3>Adviser</h3>
                                        <ul class="list-unstyled">
                                            <li>{{ paper.adviser.name }}</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h3>Panel Members</h3>
                                        <ul class="list-unstyled">
                                            <li v-for="panel in paper.panel_members" :key="panel.id">{{ panel.name
                                            }}</li>
                                        </ul>
                                    </div>
                                    <a :href="paper.document" target="_blank" class="btn um-button">Download Paper</a>
                                </div>

                                <!-- <div class="tab-pane" id="tab-2" role="tabpanel">
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
                                                    {{ comment.comment }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="tab-pane" id="tab-3" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Your Previous Comments</h4>
                                    <hr>
                                    <label class="form-label">Approve Current Status?</label>
                                    <select v-model="form.approvalStatus" @change="handleApprovalStatusChange" class="form-select mb-3">
                                        <option value="" disabled selected>Select Option</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                      </select>
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
                                    <h4 class="tab-title">Add new comment</h4>
                                    <form @submit.prevent="handleSubmitComment">
                                        <ckeditor :editor="editor" v-model="form.comment"></ckeditor>
                                        <div v-if="form.errors.comment" class="text-danger">{{ form.errors.comment
                                        }}</div>
                                        <button type="submit" class="btn um-button mt-4 btn-block">Add Comment</button>
                                    </form>

                                    for debugging only: form value => {{ form.comment }}
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



// const handleApprovalStatusChange = () => {
//     if (form.approvalStatus === 'yes') {
//         alertify.confirm('Confirm', 'Are you sure you want to approve this paper?',
//             () => {
//                 form.post(`/adviser/advised-papers/${paper.id}/approve`, {
//                     onSuccess: () => {
//                         toast.success("Paper Approved");
//                     }, 
//                     onError: (err) => {
//                         toast.error("Error Approving Paper");
//                     }
//                 });
//             },
//             () => alertify.error('Cancel')
//         );
//     }
// };

const form = useForm({
    comment: '',
    approvalStatus: '',
    file: ''
})
// const handleApprovalStatusChange = () => {
//     if (form.approvalStatus === 'yes') {
//         // Create a file input element
//         const input = document.createElement('input');
//         input.type = 'file';
//         input.accept = 'application/pdf'; // Define accepted file types if necessary

//         // Create a div element to hold the file input
//         const fileInputContainer = document.createElement('div');
//         fileInputContainer.appendChild(input);

//         alertify.confirm('Confirm', fileInputContainer, // Attach the file input to the dialog
//             () => {
//                 // Access the selected file using input.files[0] if needed
//                 const selectedFile = input.files[0];
                
//                 // Proceed with your logic, for example, sending the file via API
//                 if (selectedFile) {
//                     const formData = new FormData();
//                     formData.append('file', selectedFile);

//                     form.post(`/adviser/advised-papers/${paper.id}/approve`, formData, {
//                         headers: {
//                             'Content-Type': 'multipart/form-data'
//                         },
//                         onSuccess: () => {
//                             toast.success("Paper Approved");
//                         }, 
//                         onError: (err) => {
//                             toast.error("Error Approving Paper");
//                         }
//                     });
//                 } else {
//                     alertify.error('No file selected');
//                 }
//             },
//             () => alertify.error('Cancel')
//         );
//     }
// };
const handleApprovalStatusChange = () => {
    alertify.confirm("Confirm", "Are you sure you want to approve this paper?",
        () => {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.pdf';

            input.addEventListener('change', (event) => {
                form.file = event.target.files[0];

                if (form.file) {
                    const formData = new FormData();
                    formData.append('file', form.file);

                    form.post(`/adviser/advised-papers/${paper.id}/approve`, {
                        onSuccess: () => {
                            toast.success("Paper Approved");
                        },
                        onError: (err) => {
                            toast.error("Error Approving Paper");
                        }
                    });
                } else {
                    alertify.error("No file selected");
                }
            });

            input.click();
        },
        () => {
            alertify.error('Paper approval canceled');
        }
    );
};

const handleSubmitComment = () => {
    // console.log(form.comment)
    form.post(`/adviser/advised-papers/${paper.id}/comment`, {
        onSuccess: () => {
            toast.success("Comment Added");
            form.comment = '';
        }, onError: (err) => {
            toast.error("Error Adding Comment");
        }
    })
}


</script>