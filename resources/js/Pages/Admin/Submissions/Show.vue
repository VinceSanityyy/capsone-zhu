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
                                <!-- <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-5"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                                        Calendar</a></li> -->
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
                                                        <div v-for="index in (researchPaper.author.degree_type === 'masters' ? 4 : 5)"
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
                                                        </div>
                                                        <div v-if="form.errors.panels" class="text-danger">{{
                                                            form.errors.panels }}</div>
                                                        <button class="btn um-button">Save Changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h3>Status</h3>
                                                <!-- <ul class="list-unstyled">
                                                    <li>{{ researchPaper.status }}</li>
                                                </ul> -->
                                                <select @change="handleResearchStatus" v-model="form.research_status" class="form-control mb-3">
                                                    <option selected="">Open this select menu</option>
                                                    <option v-for="stat in status" :key="stat.name" :value="stat.name" :selected="researchPaper.status === stat.name">{{ stat.name }}</option>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <h3>For Scheduling</h3>
                                                <ul class="list-unstyled">
                                                    <li>{{ researchPaper.for_scheduling }}</li>
                                                </ul>
                                            </div>
                                            <div class="mb-4">
                                                <h3>Defense Completed</h3>
                                                <!-- <ul class="list-unstyled">
                                                    <li>{{ researchPaper.defense_schedules.is_done }}</li>
                                                </ul> -->
                                                <select @change="handleDefenseStatus" class="form-control mb-3" v-model="form.defense_status">
                                                    <option value="1" :selected="researchPaper.defense_schedules?.is_done == 1">Yes</option>
                                                    <option value="0" :selected="researchPaper.defense_schedules?.is_done == 0">No</option>
                                                </select>
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
                                <!-- <div class="tab-pane fade" id="tab-5">
                                    <FullCalendar
                                        class='demo-app-calendar'
                                        :options='calendarOptions'
                                    >
                                        <template v-slot:eventContent='arg'>
                                        <b>{{ arg.timeText }}</b>
                                        <i>{{ arg.event.title }}</i>
                                        </template>
                                    </FullCalendar>
                                </div> -->
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
import { ref, reactive } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue';
import { useForm } from '@inertiajs/vue3'
import { useToast } from "vue-toastification";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
// import { INITIAL_EVENTS, createEventId } from './event-utils'

const toast = useToast();
const editor = ClassicEditor;

const handleResearchStatus = (e) =>{
    console.log(e.target.value)
    alertify.confirm('Notice', 'Change research status?',
        () => {
            router.put(`/admin/research-paper/${researchPaper.id}/change-status`, {status: e.target.value }, {
                onSuccess: () => {
                    toast.success('Defense Status Updated')
                },
                onError: () =>{
                    toast.error('Error Updating Defense Status')
                }
            })
        },
        () => alertify.error('Cancel')
    );
}
const handleDefenseStatus = (e) => {
    alertify.confirm('Notice', 'Change defense status?',
        () => {
            router.put(`/admin/schedules/${researchPaper.defense_schedules.id}/update`, {status: e.target.value }, {
                onSuccess: () => {
                    toast.success('Defense Status Updated')
                },
                onError: () =>{
                    toast.error('Error Updating Defense Status')
                }
            })
        },
        () => alertify.error('Cancel')
    );
}

const handleDateClick = (info) =>{
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


const status  = reactive([
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

const { researchPaper, panelMembers, adminComments } = defineProps({
    researchPaper: Object,
    panelMembers: Object,
    adminComments: Object
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