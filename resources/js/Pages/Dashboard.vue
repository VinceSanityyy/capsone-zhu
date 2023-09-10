<template>
  <MainLayout>
    <h1 class="h3 mb-3"><strong>Admin</strong> Dashboard</h1>
    <div class="row">
      <div class="col-xl-6 col-xxl-5 d-flex">
        <div class="w-100">
          <div class="row">
            <div class="col-sm-6">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col mt-0">
                      <h5 class="card-title">Total Users</h5>
                    </div>

                    <div class="col-auto">
                      <div class="stat text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="feather feather-users align-middle">
                          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                          <circle cx="9" cy="7" r="4"></circle>
                          <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                          <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                      </div>
                    </div>
                  </div>
                  <h1 class="mt-1 mb-3">{{ users.length }}</h1>
                  <div class="mb-0">
                    <span class="text-muted">Including students and faculty</span>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col mt-0">
                      <h5 class="card-title">Number of Submissions</h5>
                    </div>

                    <div class="col-auto">
                      <div class="stat text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="feather feather-users align-middle">
                          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                          <circle cx="9" cy="7" r="4"></circle>
                          <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                          <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                      </div>
                    </div>
                  </div>
                  <h1 class="mt-1 mb-3">0</h1>
                  <div class="mb-0">
                    <!-- <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.25% </span> -->
                    <span class="text-muted">Since last week</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col mt-0">
                      <h5 class="card-title">Pending Students</h5>
                    </div>

                    <div class="col-auto">
                      <div class="stat text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="feather feather-dollar-sign align-middle">
                          <line x1="12" y1="1" x2="12" y2="23"></line>
                          <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                      </div>
                    </div>
                  </div>
                  <h1 class="mt-1 mb-3">{{ pendingUsers }}</h1>
                  <div class="mb-0">
                    <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i></span>
                    <span class="text-muted">Since last week</span>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col mt-0">
                      <h5 class="card-title">Other Details here</h5>
                    </div>

                    <div class="col-auto">
                      <div class="stat text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="feather feather-shopping-cart align-middle">
                          <circle cx="9" cy="21" r="1"></circle>
                          <circle cx="20" cy="21" r="1"></circle>
                          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                      </div>
                    </div>
                  </div>
                  <h1 class="mt-1 mb-3">0</h1>
                  <div class="mb-0">
                    <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i></span>
                    <span class="text-muted">Details</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-6 col-xxl-7">
        <div class="card flex-fill w-100">
          <div class="card-header">
            <h5 class="card-title mb-0">Users</h5>
          </div>
          <div class="card-body py-3">
            <div class="chart chart-sm">
              <fusioncharts :type="type" :width="width" :height="height" :dataformat="dataFormat"
                :dataSource="dataSource">
              </fusioncharts>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{ $page.props }}

  </MainLayout>
</template>
  
<script setup>
import { defineProps, ref, onMounted } from 'vue';
import MainLayout from './../Layouts/MainLayout.vue';

const type = 'column2d';
const width = '100%';
const height = '100%';
const dataFormat = 'json';

const { users, pendingUsers, userPerCourse } = defineProps({
  users: Object,
  pendingUsers: Number,
  userPerCourse: Array
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