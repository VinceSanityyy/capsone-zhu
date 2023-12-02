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
                                    &emsp;
                                <b>{{ arg.event.extendedProps.author }}</b>
                            </template>
                        </FullCalendar>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, reactive, watch, computed, onUnmounted } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue';
import { useToast } from "vue-toastification";
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import momentPlugin from '@fullcalendar/moment'
import { formatDate } from '@fullcalendar/core'
import { router } from '@inertiajs/vue3'

const toast = useToast();
const handleDateClick = (selectInfo) => {
    console.log(selectInfo)
    prompt(selectInfo)
}

const promptContent = (papers) => {
    console.log(papers)
    const options = papers.map(paper => `<option value="${paper.id}"><strong>Author's Name:</strong> ${paper.author.name}</option>`).join('');
    return `
    <select id="paperSelect" class="form-select mb-3">
      ${options}
    </select>
  `;
};


const handleEventClick = (info) => {
    console.log(info.event.title)
}

onUnmounted(() => {
    console.log('unmounted')
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
                    <td>${selectedinfo.event.extendedProps.is_done == 1 ? 'Done' : 'Waiting for Schedule'}</td>
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
            'onok': () => { router.visit(`/admin/research-paper/${selectedinfo.event.extendedProps.research_paper_id}`) },
            'oncancel': () => { console.log('cancel') },
        })
        .setHeader('Schedule Details')
        .setContent(eventContent)
        .set('resizable', true)
        .set('labels', {ok:'More Details', cancel:'Close'})
        .resizeTo('50%', 450)
        .show();
};

const addEvent = () => {
    console.log(form)
    router.post(`/admin/research-papers/${form.researchPaperId}/plot-schedule`, form, {
        onSuccess: () => {
            toast.success("Schedule Plotted");
        },
        onError: (err) => {
            toast.error("Error Plotting Schedule");
        },
        onProgress: progress => {
            console.log(progress);
        }
    });
};

const form = reactive({
    researchPaperId: null,
    startStr: null,
    endStr: null
})
const formTransformer = (selectInfo, selectedPaperId) => {
    form.startStr = selectInfo.startStr
    form.endStr = selectInfo.endStr
    form.researchPaperId = selectedPaperId
}

const props = defineProps({
    papers: Object,
    schedules: Object
})

const prompt = (selectInfo) => {
    const startStr = formatDate(selectInfo.startStr, { month: 'long', day: 'numeric', timeZoneName: 'short', locale: 'en' });
    const endStr = formatDate(selectInfo.endStr, { month: 'long', day: 'numeric', timeZoneName: 'short', locale: 'en' });

    alertify.confirm()
        // .set('labels', { ok: 'Confirm', cancel: 'Cancel' })
        .set('labels', { ok: 'Confirm', cancel: 'Cancel' })
        .setHeader('Choose a research paper for the indicated date and time of defense')
        .setContent(promptContent(props.papers))
        .set('onok', (event, value) => {
            const selectedPaperId = document.getElementById('paperSelect').value;
            if (selectedPaperId) {
                const selectedPaper = props.papers.find(paper => paper.id === parseInt(selectedPaperId));
                console.log('Confirmed! Selected Paper:', selectedPaper.title);
                formTransformer(selectInfo, selectedPaperId);
                addEvent()
                calendarOptions.events = props.schedules
            } else {
                console.log('No paper selected.');
            }
        })
        .set('oncancel', () => console.log('Cancelled!'))
        .show()
        .setting({ 'closableByDimmer': true });
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
        // events: events,
        events: props.schedules,
        editable: true,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: false,
        height: 650,
        contentHeight: 650,
        // dateClick: handleDateClick,
        select: handleDateClick,
        slotDuration: '01:00:00',
        slotMinTime: "07:00",
        slotMaxTime: "18:00",
        eventClick: showEventDetails,
        eventAdd: addEvent,
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