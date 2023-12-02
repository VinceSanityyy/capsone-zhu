<template>
  <MainLayout>
    <div class="row mb-2 mb-xl-3">
      <div class="col-auto d-none d-sm-block">
        <h3 style = "color:white;">Dashboard</h3>
      </div>

      <!-- <div class="col-auto ms-auto text-end mt-n1">
        <a href="#" class="btn btn-light bg-white me-2">Invite a Friend</a>
        <a href="#" class="btn btn-primary">New Project</a>
      </div> -->
    </div>
    <div class="row justify-content-center">
      <div v-for="(card, index) in cards" :key="index" class="col-md-2">
        <div class="card cards" @click="card.click">
          <div class="card-body" style="hover:p">
            <div class="row">
              <div class="col mt-0">
                <h5 class="card-title" style = "color:white;">{{ card.title }}</h5>
              </div>
              <div class="col-auto">
                <div class="stat text-primary">
                  <i class="bi bi-journal-medical"></i>
                </div>
              </div>
            </div>
            <h1 class="mt-1 mb-3">{{ card.value }}</h1>
            <div class="mb-0">
              <!--<span
                :class="{ 'badge badge-success-light': card.isPositiveChange, 'badge badge-danger-light': !card.isPositiveChange } ">
               
                {{ card.change }} 
              </span>-->
              <span class="text-muted">{{ card.changeDescription }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- {{ $page.props }} -->
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title">Submission List</h5>
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-3 offset-md-6">
              <select class="form-control mb-3" v-model="selectedDegree" @change="handleFilterChange">
                <option selected disabled>Select Degree</option>
                <option value="masteral">Masters</option>
                <option value="doctoral">Doctors</option>
              </select>
            </div>
          </div>

          <div class="table-responsive">
            <DataTable class="display" ref="table" id="example" :data="filteredResults" :columns="columns">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Title</th>
                  <th>Name</th>
                  <th>Degree Type</th>
                  <th>Status</th>
                  <th>Adviser</th>
                  <th>Program</th>
                  <th>Panels</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <!-- <tbody>
                <tr v-for="submission in submissions" :key="submission.id">
                  <td>{{ submission.created_at }}</td>
                  <td>{{ submission.title }}</td>
                  <td>{{ submission.author.name }}</td>
                  <td>{{ submission.author.degree_type.toUpperCase() }}</td>
                  <td v-html="statusBadge(submission)"></td>
                  <td>{{ submission.adviser.name }}</td>
                  <td>{{ submission.author.course.name }}</td>
                  <td>{{ submission.pannels }}</td>
                  <td>
                    <Link :href="`/admin/research-paper/${submission.id}`" class="btn btn-sm um-button">View</Link>
                  </td>
                </tr>
              </tbody> -->
            </DataTable>
          </div>
        </div>
      </div>
    </div>
  
  </MainLayout>
</template>
  
<script setup>
import { defineProps, ref, onMounted, computed, reactive, toRef, nextTick } from 'vue';
import { Link, usePage, router, useForm } from '@inertiajs/vue3'

import MainLayout from './../Layouts/MainLayout.vue';
import DataTable from 'datatables.net-vue3';

const columns = [
  { data: 'created_at' },
  { data: 'title' },
  { data: 'author.name' },
  { data: 'author.degree_type' },
  {
    data: 'status',
    render: function (data, type, row) {
      return statusBadge(row);
    },
  },
  { data: 'adviser.name' },
  { data: 'author.course.name' },
  { data: 'pannels' },
  {
    data: null,
    render: function (data, type, row) {
      return `<a href="/admin/research-paper/${data.id}" class="btn btn-sm um-button" style = "background-color:#090c29;">View</a>`;
    },
  },
];

const statusBadge = (submission) => {
  switch (submission.status) {
    case 'quality_checking':
      return '<span class="badge bg-warning">Quality Checking</span>';
    case 'title_defense':
      return '<span class="badge bg-secondary">Title Defense</span>';
    case 'final_defense':
      return '<span class="badge bg-danger">Final Defense</span>';
    case 'outline_defense':
      return '<span class="badge bg-info">Outline Defense</span>';
    case 'completed':
      return '<span class="badge bg-success">Completed</span>';
    case 'final_checking':
      return '<span class="badge bg-dark">Final Checking</span>';
    case 'archived':
      return '<span class="badge bg-dark">Archived</span>';
    case 'final_submission':
      return '<span class="badge bg-dark">Final Submission</span>';
    default:
      break
  }
}

const selectedDegree = ref('');
const filteredResults = ref([]);

onMounted(() => {
  filteredResults.value = props.submissions;
});

const handleFilterChange = () => {
  let filteredSubmissions;
  if(selectedDegree.value){
    filteredSubmissions = props.submissions.filter(submission => submission.author.degree_type === selectedDegree.value);
    filteredResults.value = filteredSubmissions;
  } else {
    filteredResults.value = props.submissions;
  }
};


const props = defineProps({
  users: Object,
  pendingUsers: Number,
  userPerCourse: Array,
  submissions: Object,
  total_submissions: Object,
  announcements: Object,
  barChartData: Array,
  courses: Object,
});

const countSubmissionsByStatus = computed(() => {
  const statusesToCount = ['title_defense', 'final_defense', 'outline_defense', 'quality_checking', 'final_submission'];

  return statusesToCount.reduce((countObj, status) => {
    countObj[status] = props.total_submissions.filter(submission => submission.status === status).length;
    return countObj;
  }, {});
});

// const { users, pendingUsers, userPerCourse, submissions, total_submissions, announcements, barChartData, courses } = defineProps({
//   users: Object,
//   pendingUsers: Number,
//   userPerCourse: Array,
//   submissions: Object,
//   total_submissions: Object,
//   announcements: Object,
//   barChartData: Array,
//   courses: Object,
// });


const cards = ref([
  {
    title: 'Users For Approval',
    value: props.pendingUsers,
    change: '2.4%',
    isPositiveChange: true,
    click: () => {
      router.get(`/admin/users-pending`)
    }
  },
  {
    title: 'For Title Defense',
    value: countSubmissionsByStatus.value.title_defense,
    change: '0.8%',
    isPositiveChange: false,
    click: () => {
      let filteredSubmissions;
      filteredSubmissions = props.submissions.filter(submission => submission.status === 'title_defense');
      filteredResults.value = filteredSubmissions;
    }
  },
  {
    title: 'For Outline Defense',
    value: countSubmissionsByStatus.value.outline_defense,
    change: '0.8%',
    isPositiveChange: false,
    click: () => {
      let filteredSubmissions;
      filteredSubmissions = props.submissions.filter(submission => submission.status === 'outline_defense');
      filteredResults.value = filteredSubmissions;
    }
  },
  {
    title: 'For Final Defense',
    value: countSubmissionsByStatus.value.final_defense,
    change: '0.8%',
    isPositiveChange: false,
    click: () => {
      let filteredSubmissions;
      filteredSubmissions = props.submissions.filter(submission => submission.status === 'final_defense');
      filteredResults.value = filteredSubmissions;
    }
  },
  {
    title: 'For Technical Checking',
    value: countSubmissionsByStatus.value.quality_checking,
    change: '0.8%',
    isPositiveChange: false,
    click: () => {
      let filteredSubmissions;
      filteredSubmissions = props.submissions.filter(submission => submission.status === 'quality_checking');
      filteredResults.value = filteredSubmissions;
    }
  },
  {
    title: 'For Final Submission',
    value: countSubmissionsByStatus.value.final_submission,
    change: '0.8%',
    isPositiveChange: false,
    click: () => {
      let filteredSubmissions;
      filteredSubmissions = props.submissions.filter(submission => submission.status === 'final_submission');
      filteredResults.value = filteredSubmissions;
    }
  },
  // {
  //   title: 'Total Submissions',
  //   value: total_submissions.length,
  //   change: '0.8%',
  //   isPositiveChange: false,
  //   click: () => {
  //     router.get(`/dashboard`)
  //   }
  // },
]);




</script>

<style scoped>
@import 'datatables.net-dt';

.cards {
  transition: all 0.2s ease;
  cursor:auto;
  font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #068CCF;
  font-size: larger;
}

.cards:hover {
  box-shadow: 5px 5px 5px 5px #CFCFC4;
  transform: scale(1.1);
}


</style>

