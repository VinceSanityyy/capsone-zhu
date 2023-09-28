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
        <div class="card cards" @click="card.click">
          <div class="card-body" style="hover:p">
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
                <option value="">Select Degree</option>
                <option value="masteral">Masters</option>
                <option value="doctoral">Doctors</option>
              </select>
            </div>
          </div>

          <div class="table-responsive">
            <DataTable class="display" ref="table" id="example">
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
              <tbody>
                <tr v-for="submission in formattedSubmissions" :key="submission.id">
                  <td>{{ submission.formattedDate }}</td>
                  <td>{{ submission.title }}</td>
                  <td>{{ submission.author.name }}</td>
                  <td>{{ submission.author.degree_type.toUpperCase() }}</td>
                  <td v-html="statusBadge(submission)"></td>
                  <td>{{ submission.adviser.name }}</td>
                  <td>{{ submission.author.course.name }}</td>
                  <td>{{ submission.pannels }}</td>
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
import { Link, usePage, router } from '@inertiajs/vue3'

import MainLayout from './../Layouts/MainLayout.vue';
import DataTable from 'datatables.net-vue3';
import axios from 'axios';

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


const selectedDegree = ref('');
const handleFilterChange = () => {
  const params = [];
  if (selectedDegree.value) {
    params.push(`degree_type=${selectedDegree.value}`);
  }
  const queryString = params.join('&');
  router.get(`/dashboard?${queryString}`);
};

const countSubmissionsByStatus = computed(() => {
  const statusesToCount = ['title_defense', 'final_defense', 'outline_defense', 'quality_checking'];

  return statusesToCount.reduce((countObj, status) => {
    countObj[status] = total_submissions.filter(submission => submission.status === status).length;
    return countObj;
  }, {});
});

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



const { users, pendingUsers, userPerCourse, submissions, total_submissions, announcements } = defineProps({
  users: Object,
  pendingUsers: Number,
  userPerCourse: Array,
  submissions: Object,
  total_submissions: Object,
  announcements: Object
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
      console.log(selectedDegree.value)
      router.get(`/dashboard?status=title_defense`)
    }
  },
  {
    title: 'For Outline Defense',
    value: countSubmissionsByStatus.value.outline_defense,
    change: '0.8%',
    isPositiveChange: false,
    click: () => {
      router.get(`/dashboard?status=outline_defense`)
    }
  },
  {
    title: 'For Final Defense',
    value: countSubmissionsByStatus.value.final_defense,
    change: '0.8%',
    isPositiveChange: false,
    click: () => {
      router.get(`/dashboard?status=final_defense`)
    }
  },
  {
    title: 'For Quality Checking',
    value: countSubmissionsByStatus.value.quality_checking,
    change: '0.8%',
    isPositiveChange: false,
    click: () => {
      router.get(`/dashboard?status=quality_checking`)
    }
  },
  {
    title: 'Total Submissions',
    value: total_submissions.length,
    change: '0.8%',
    isPositiveChange: false,
    click: () => {
      router.get(`/dashboard`)
    }
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

<style scoped>
@import 'datatables.net-dt';

.cards{
transition: all 0.2s ease;
cursor: pointer;


}
.cards:hover{
box-shadow: 5px 6px 6px 2px #e9ecef;
transform: scale(1.1);
}
</style>
