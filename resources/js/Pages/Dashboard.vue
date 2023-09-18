<template>
  <MainLayout>
    <div class="row mb-2 mb-xl-3">
      <div class="col-auto d-none d-sm-block">
        <h3>Dashboard</h3>
      </div>

      <!-- <div class="col-auto ms-auto text-end mt-n1">
        <a href="#" class="btn btn-light bg-white me-2">Invite a Friend</a>
        <a href="#" class="btn btn-primary">New Project</a>
      </div> -->
    </div>
    <div class="row justify-content-center">
      <div v-for="(card, index) in cards" :key="index" class="col-md-2">
        <Link :href="card.link">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col mt-0">
                <h5 class="card-title">{{ card.title }}</h5>
              </div>

              <div class="col-auto">
                <div class="stat text-primary">
                  <i class="bi bi-journal-medical"></i>
                </div>
              </div>
            </div>
            <h1 class="mt-1 mb-3">{{ card.value }}</h1>
            <div class="mb-0">
              <span
                :class="{ 'badge badge-success-light': card.isPositiveChange, 'badge badge-danger-light': !card.isPositiveChange }">
                <i class="mdi mdi-arrow-bottom-right"></i>
                {{ card.change }}
              </span>
              <span class="text-muted">{{ card.changeDescription }}</span>
            </div>
          </div>
        </div>
        </Link>
      </div>
    </div>
    <!-- {{ $page.props }} -->
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title">Submission List</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <DataTable class="display" ref="table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Title</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Adviser</th>
                  <th>Program</th>
                  <th>Panels</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="submission in formattedSubmissions" :key="submission.id">
                  <td>{{ submission.formattedDate }}</td>
                  <td>{{ submission.title }}</td>
                  <td>{{ submission.user.name }}</td>
                  <td v-html="statusBadge(submission)"></td>
                  <td>{{ submission.adviser }}</td>
                  <td>{{ submission.user.course.name }}</td>
                  <td>{{ submission.panels }}</td>
                  <td>
                    <Link :href="`/wala`" class="btn btn-sm um-button">View</Link>
                  </td>
                </tr>
              </tbody>
            </DataTable>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>
  
<script setup>
import { defineProps, ref, onMounted, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3'

import MainLayout from './../Layouts/MainLayout.vue';
import DataTable from 'datatables.net-vue3';


const type = 'column2d';
const width = '100%';
const height = '100%';
const dataFormat = 'json';

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
    default:
      break
  }
}

const countSubmissionsByStatus = computed(() => {
  const statusesToCount = ['title_defense', 'final_defense', 'outline_defense', 'quality_checking'];
  
  return statusesToCount.reduce((countObj, status) => {
    countObj[status] = submissions.filter(submission => submission.status === status).length;
    return countObj;
  }, {});
});

console.log(countSubmissionsByStatus.value)

const formattedSubmissions = computed(() => {
  return submissions.map(submission => {
    const date = new Date(submission.created_at);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = date.toLocaleDateString('en-US', options);
    return {
      ...submission,
      formattedDate,
    };
  });
});


const { users, pendingUsers, userPerCourse, submissions } = defineProps({
  users: Object,
  pendingUsers: Number,
  userPerCourse: Array,
  submissions: Object
});

const dataSource = {
  chart: {
    caption: 'Total number of students per course.',
    subcaption: 'This includes the accounts that are pending for approval',
    xaxisname: 'Courses',
    yaxisname: 'Number of students',
    numbersuffix: '',
    theme: 'fusion',
  },
  data: userPerCourse,
};

const cards = ref([
  {
    title: 'Users For Approval',
    value: pendingUsers,
    change: '2.4%',
    isPositiveChange: true,
    link: '/admin/users'
  },
  {
    title: 'For Title',
    value: countSubmissionsByStatus.value.title_defense,
    change: '0.8%',
    isPositiveChange: false,
    link: '/asdf'
  },
  {
    title: 'For Outline',
    value: countSubmissionsByStatus.value.outline_defense,
    change: '0.8%',
    isPositiveChange: false,
    link: '/asd'
  },
  {
    title: 'For Final',
    value: countSubmissionsByStatus.value.final_defense,
    change: '0.8%',
    isPositiveChange: false,
    link: '/asd'
  },
  {
    title: 'For Quality Checking',
    value: countSubmissionsByStatus.value.quality_checking,
    change: '0.8%',
    isPositiveChange: false,
    link: '/asd'
  },
]);

const fusionChartRef = ref(null);

// Function to handle chart initialization
const onChartInitialized = (chartInstance) => {
  fusionChartRef.value = chartInstance;
};

onMounted(() => {
  // Check if FusionCharts instance is available
  if (fusionChartRef.value) {
    fusionChartRef.value.setChartData(dataSource);
  }
});
</script>

<style>
@import 'datatables.net-dt';
</style>