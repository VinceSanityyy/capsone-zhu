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
                                        Admin Comments</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-6"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                                        Adviser Endorsement Forms</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-7"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                                        Panel Evaluation Forms</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-8"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                                        Panel Comments</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-9"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                                        Adviser Comments</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-10"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                                        Receipts Submitted</a></li>
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
                                                    <li>{{ researchPaper.author.name }} - {{
                                                        researchPaper.author.degree_type }}
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
                                                    <li v-for="panel in researchPaper.panel_members" :key="panel.id">{{
                                                        panel.name
                                                    }}</li>
                                                </ul>
                                                <p v-else>No panels assigned</p>
                                                <br>
                                                <div class="container">
                                                    <form @submit.prevent="addPanelMembers">
                                                        <!-- <div v-for="index in (researchPaper.author.degree_type === 'masteral' ? 4 : 5)"
                                                            :key="index" class="mb-3 row">
                                                            <label for="inputName" class="col-4 col-form-label">Panel Member
                                                                #
                                                                {{ index }}</label>
                                                            <div class="col-6">
                                                                <select class="form-select mb-3"
                                                                    v-model="form.panels[index - 1]">
                                                                    <option selected="" disabled>Open this select menu
                                                                    </option>
                                                                    <option v-for="panel in panelMembers" :key="panel.id"
                                                                        :value="panel.id">{{ panel.name }}</option>
                                                                </select>
                                                            </div>
                                                        </div> -->
                                                        <v-select
                                                        multiple
                                                        v-model="form.panels"
                                                        :options="panelMembers"
                                                        label="name"
                                                        
                                                        :selectable="() => form.panels.length < (researchPaper.author.degree_type === 'masteral' ? 4 : 5)"
                                                        @input="setSelected"
                                                        />
                                                        <br>
                                                        <div v-if="form.errors.panels" class="text-danger">{{
                                                            form.errors.panels }}</div>
                                                        <button class="btn um-button">Save Changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4" v-if="['final_submission','completed'].includes(researchPaper.status)">
                                                <h3>Status: {{ researchPaper.status }}</h3>
                                                <div>
                                                    <label class="form-check" v-for="checklist in checkLists"
                                                        :key="checklist.id">
                                                        <input :checked="researchPaper[checklist.value]"
                                                            class="form-check-input" type="checkbox"
                                                            :value="checklist.value" @change="handleFinalSubmissionProcess"
                                                            >
                                                        <span class="form-check-label">
                                                            {{ checklist.label }}
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- <div class="mb-4">
                                                <h3>For Scheduling</h3>
                                                <ul class="list-unstyled">
                                                    <li>{{ researchPaper.for_scheduling }}</li>
                                                </ul>
                                            </div> -->
                                            <div class="mb-4"
                                                v-if="['title_defense', 'outline_defense', 'final_defense'].includes(researchPaper.status)">
                                                <h3>Defense Status: <span :class="researchPaper?.defense_schedules?.is_done ? 'badge bg-success' : 'badge bg-info'">{{ researchPaper?.defense_schedules?.is_done ? 'Done' : 'Waiting' }}</span></h3>
                                                <select @change="handleDefenseStatus" class="form-control mb-3"
                                                    v-model="form.defense_status">
                                                    <option value="" disabled selected>Select Option</option>
                                                    <option value="1"
                                                        :selected="researchPaper.defense_schedules?.is_done == 1">Yes
                                                    </option>
                                                    <option value="0"
                                                        :selected="researchPaper.defense_schedules?.is_done == 0">No
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- <div class="mb-4" v-if="['title_defense', 'outline_defense', 'final_defense', 'quality_checking'].includes(researchPaper.status)"> -->
                                            <div class="mb-4" v-if="['quality_checking'].includes(researchPaper.status)">
                                                <h3>Paper Status: {{ researchPaper.status }}</h3>
                                                <label class="form-label" for="">Approve current status?</label>
                                                <select @change="handleResearchStatus" class="form-control mb-3"
                                                    v-model="form.research_status">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <a :href="researchPaper.document" target="_blank"
                                                    class="btn um-button">Download Paper</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-4">
                                    <br>
                                    <h4 class="tab-title">Your Comments</h4>
                                    <hr>
                                    <div v-for="comment in adminComments" :key="comment.id" class="card-body h-100">
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
                                <div class="tab-pane fade" id="tab-6">
                                    <br>
                                    <h4 class="tab-title">Forms Attached (by adviser)</h4>
                                    <hr>
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
                                            <tr v-for="endorsement in adviserEndorsementForms" :key="endorsement.id">
                                                <td>Endorsement Form</td>
                                                <td>{{ endorsement.stage_submitted }}</td>
                                                <td>{{ endorsement.created_at }}</td>
                                                <td>
                                                    <a :href="endorsement.file_path" class="btn btn-sm um-button"
                                                        target="_blank">Download</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </DataTable>
                                </div>
                                <div class="tab-pane fade" id="tab-7">
                                    <br>
                                    <h4 class="tab-title">Evaluation forms Attached by pannelists</h4>
                                    <hr>
                                    <DataTable class="display" ref="table">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Panel Name</th>
                                                <th>Stage Attached</th>
                                                <th>Date Submitted</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="evaluation in panelMemberEvaluationForms" :key="evaluation.id">
                                                <td>Endorsement Form</td>
                                                <td>{{ evaluation.panel.name }}</td>
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
                                <div class="tab-pane" id="tab-8" role="tabpanel">
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
                                                    <div v-html="comment.comment"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-9" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Adviser Comments</h4>
                                    <hr>
                                    <div v-for="comment in adviserComments" :key="comment.id" class="card-body h-100">
                                        <div class="card-body h-50">

                                            <hr>
                                            <div class="d-flex align-items-start">
                                                <img src="https://edukasyon-production.s3.amazonaws.com/uploads/school/avatar/17455/red.jpg"
                                                    width="36" height="36" class="rounded-circle me-2" alt="Charles Hall">
                                                <div class="flex-grow-1">
                                                    <small class="float-end text-navy"></small>
                                                    <strong>{{ comment.user.name }}</strong> wrote a comment <strong>
                                                        on the study {{ researchPaper.title }}</strong><br>
                                                    <small class="text-muted">{{ comment.date_created }}</small>

                                                    <div class="border text-sm text-muted p-2 mt-1">
                                                        <div v-html="comment.comment"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-10" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Submitted Receipts</h4>
                                    <hr>
                                    <DataTable class="display" ref="table">
                                        <thead>
                                            <tr>
                                                <th>Amount</th>
                                                <th>Reference Number</th>
                                                <th>Status</th>
                                                <th>Date Submitted</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="receipt in receipts" :key="receipt.id" class="text-center">
                                                <td>{{ receipt.amount }}</td>
                                                <td>{{ receipt.reference_number }}</td>
                                                <td>
                                                    <span v-if="receipt.is_approved == 0" class="badge bg-warning">Pending</span>
                                                    <span v-else class="badge bg-success">Approved</span>
                                                </td>
                                                <td>{{ receipt.created_at }}</td>
                                                <td>
                                                    <a target="_blank" :href="receipt.receipt" class="btn um-button">View</a>
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
        <!-- <h1>{{ researchPaper }}</h1> -->
    </MainLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { ref, reactive, onUnmounted, computed } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue';
import { useForm } from '@inertiajs/vue3'
import { useToast } from "vue-toastification";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import DataTable from 'datatables.net-vue3';

import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
// import { INITIAL_EVENTS, createEventId } from './event-utils'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

onUnmounted(() => {
    alertify.confirm().destroy()
})

const setSelected = (val) => {
    console.log(val)
    // form.panels = val
}

const toast = useToast();
const editor = ClassicEditor;
const checkLists = ref([
    {
        label: '1 copy of the final manuscript in book form (hardbound)',
        checked: false,
        value: 'has_submitted_manuscript'
    },
    {
        label: '3 CDs containing the final manuscript (in Word and PDF format)',
        checked: false,
        value: 'has_submitted_cd'
    },
    {
        label: 'Final adviser’s payment receipt',
        checked: false,
        value: 'has_submitted_final_receipt'
    },
    {
        label: '1 printed copy of the published paper',
        checked: false,
        value: 'has_submitted_printed_materials'
    },
    {
        label: 'Paid Final advisers fee',
        checked: false,
        value: 'has_paid_final_adviser_fee',
    },
]);


const handleFinalSubmissionProcess = (e) => {

    if (e.target.value === 'has_paid_final_adviser_fee' && e.target.checked) {
        alertify.confirm('Enter Receipt details', 'Are you sure you want to mark this as paid?',
            () => {
                // Callback for OK button
                const referenceNumber = document.getElementById('reference_number').value;
                const amount = document.getElementById('amount').value;
                const date = document.getElementById('date').value;
                console.log('Reference Number:', referenceNumber);
                console.log('Amount:', amount);
                console.log('Date:', document.getElementById('date').value);
                axios.post(`/admin/research-paper/${researchPaper.id}/add-adviser-fee`, {
                    status: e.target.value,
                    checked: e.target.checked,
                    reference_number: referenceNumber,
                    amount: amount,
                    date: date
                })
                .then(response => {
                    // Handle success
                    researchPaper.status = 'completed';
                    toast.success('Receipt Added');
                })
                .catch(error => {
                    // Handle error
                    e.target.checked = false;
                    toast.error(error.response.data.message);
                });
            },
            () => {
                e.target.checked = false;
                toast.error('Cancelled');
            }
        ).setContent(`
        <label>Enter Reference Number</label><input type="text" class="form-control" id="reference_number">
        <label>Enter Amount</label><input type="number" class="form-control" id="amount">
        <label>Date Issued: </label><input type="date" class="form-control" id="date">
        `);
    } else {
        router.put(`/admin/research-paper/${researchPaper.id}/update-final-paper-checklist`, {
            status: e.target.value,
            checked: e.target.checked
        }, {
            onSuccess: () => {
                toast.success('Paper Status Updated')
            },
            onError: () => {
                toast.error('Error Updating Status')
            }
        })
    }
}

const handleResearchStatus = (e) => {
    alertify.confirm('Notice', 'Change research status?',
        () => {

            if (researchPaper.status == 'final_checking') {
                toast.error('Final checking approval is for adviser only.')
            } else {
                router.put(`/admin/research-paper/${researchPaper.id}/change-status`, { status: e.target.value }, {
                    onSuccess: () => {
                        toast.success('Paper Status Updated')
                    },
                    onError: () => {
                        toast.error('Error Updating Status')
                    }
                })
            }

        },
        () => alertify.error('Cancel')
    );
}

const handleDefenseStatus = (e) => {
    alertify.confirm('Notice', 'Change defense status?',
        () => {
            router.put(`/admin/schedules/${researchPaper.defense_schedules.id}/update`, { status: e.target.value }, {
                onSuccess: () => {
                    toast.success('Defense Status Updated')
                },
                onError: () => {
                    toast.error('Error Updating Defense Status')
                }
            })
        },
        () => alertify.error('Cancel')
    );
}

const handleDateClick = (info) => {
    console.log(info)
    console.log('date clicked')
}

const calendarOptions = ref({
    plugins: [
        dayGridPlugin,
        timeGridPlugin,
        interactionPlugin // needed for dateClick
    ],
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    initialView: 'dayGridMonth',
    initialEvents: [],
    editable: true,
    selectable: true,
    selectMirror: true,
    dayMaxEvents: true,
    weekends: true,
    height: 650,
    contentHeight: 650,

    dateClick: handleDateClick,
    select: console.log(1)
})

const form = useForm({
    panels: [],
    comment: '',
    defense_status: researchPaper.defense_schedules?.is_done ?? null,
    research_status: researchPaper.status
})


const status = reactive([
    {
        name: 'title_defense'
    },
    {
        name: 'final_defense'
    },
    {
        name: 'outline_defense'
    },
    {
        name: 'quality_checking'
    },
    {
        name: 'completed'
    }
])

const { researchPaper, 
    panelMembers, 
    adminComments, 
    adviserEndorsementForms, 
    panelMemberEvaluationForms, 
    panelMemberComments, 
    adviserComments,
    receipts } = defineProps({
    researchPaper: Object,
    panelMembers: Object,
    adminComments: Object,
    adviserEndorsementForms: Object,
    panelMemberEvaluationForms: Object,
    panelMemberComments: Object,
    adviserComments: Object,
    receipts: Object
})

const addPanelMembers = () => {
    form.post(`/admin/submissions/${researchPaper.id}/add-panel-members`, {
        onSuccess: () => {
            toast.success("Panel Members Added");
        }, onError: (err) => {
            console.log(err)
            toast.error("Error Adding Panel Members");
        }
    })
}

const handleSubmitComment = () => {
    form.post(`/admin/research-paper/${researchPaper.id}/comment`, {
        onSuccess: () => {
            toast.success("Comment Added");
            form.comment = '';
        }, onError: (err) => {
            toast.error("Error Adding Comment");
        }
    })
}

</script>

<style scoped>
@import 'datatables.net-dt';
</style>