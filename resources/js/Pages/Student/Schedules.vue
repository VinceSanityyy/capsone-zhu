<template>
    <MainLayout>
        <h1 class="h3 mb-3" style = "color:white;">Schedules</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <FullCalendar class='demo-app-calendar' :options='calendarOptions'>
                            <template v-slot:eventContent='arg'>
                                <b>{{ arg.timeText }}</b>
                                <i>{{ arg.event.title }}</i>
                            </template>
                        </FullCalendar>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import FullCalendar from '@fullcalendar/vue3'
import { ref, reactive, watch, computed, onUnmounted } from 'vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import momentPlugin from '@fullcalendar/moment'
import { useToast } from "vue-toastification";

const toast = useToast();

const props = defineProps({
    papers: Object,
    schedules: Object
})

onUnmounted(() => {
    alertify.confirm().destroy()
})

const showEventMarkup = (selectedinfo) => {
    return `
        <div style="padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
            <h4>Additional Information</h4>
            <table style="width: 100%; margin-top: 10px;">
                <tr>
                    <td style="width: 30%; font-weight: bold;">Research Title:</td>
                    <td>${selectedinfo.event.title}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Author:</td>
                    <td>${selectedinfo.event.extendedProps.author}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Adviser:</td>
                    <td>${selectedinfo.event.extendedProps.adviser}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Panel Members:</td>
                    <td>${selectedinfo.event.extendedProps.object.pannels}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Start</td>
                    <td>${selectedinfo.event.start}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">End</td>
                    <td>${selectedinfo.event.end}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Status</td>
                    <td>${selectedinfo.event.extendedProps.isDone ? 'Done' : 'Waiting for Schedule'}</td>
                </tr>
            </table>
        </div>`;
};

const showEventDetails = (selectedinfo) => {
    console.log(selectedinfo);
    console.log(selectedinfo.event.extendedProps.object.pannels)
    const eventContent = showEventMarkup(selectedinfo);

    alertify.confirm()
        .setting({
            'onok': () => { console.log('ok'); },
            'oncancel': () => { console.log('cancel'); },
        })
        .setHeader('Schedule Details')
        .setContent(eventContent)
        .set('resizable', true)
        .resizeTo('50%', 450)
        .show();
};

const calendarOptions = computed(() => {
    return {
        plugins: [
            momentPlugin,
            dayGridPlugin,
            timeGridPlugin,
            interactionPlugin // needed for dateClick
        ],
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        titleFormat: 'MMMM D, YYYY',
        initialView: 'dayGridMonth',

        events: props.schedules,
        editable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: false,
        height: 650,
        contentHeight: 650,
        // dateClick: handleDateClick,
        // select: handleDateClick,
        slotDuration: '01:00:00',
        slotMinTime: "07:00",
        slotMaxTime: "18:00",
        eventClick: showEventDetails,
        // eventAdd: addEvent,
        eventColor: '#af2532',
        eventDisplay: 'block',
        businessHours: {
            daysOfWeek: [1, 2, 3, 4, 5], // Monday - Thursday
            startTime: '7:00', // a start time 
            endTime: '17:00', // an end time 
        },
        selectConstraint: 'businessHours',
    }
})
</script>