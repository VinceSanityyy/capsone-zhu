<template>
  <MainLayout>
    <h1 class="h3 mb-3" style = "color:white;"><strong></strong>Reports</h1>
    <form @submit.prevent="handleDateFilter">
      <div class="row">

        <div class="col-md-4">
          <div class="mb-3">
            <label for="" class="form-label" style = "color:white;">From</label>
            <input v-model="form.from" type="date" name="" id="" class="form-control" placeholder=""
              aria-describedby="helpId">
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="" class="form-label" style = "color:white;">To</label>
            <input v-model="form.to" type="date" name="" id="" class="form-control" placeholder=""
              aria-describedby="helpId">
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <button type="submit" class="btn um-button mt-4" style = "background-color:#e0ba1f;">Apply Dates</button>
          </div>
        </div>
        <div class="mb-3">
              <label for="" class="form-label" style = "color:white;">Select a Course to filter</label>
              <select class="form-select" name="" id="" @change="handlePiechartData">
                <option :value="course.id" v-for="course in courses" :key="course.id">{{ course.name }}</option>
              </select>
            </div>
      </div>
    </form>
    <div class="row">
      <div class="col-md-6">
        <div class="card flex-fill">
          <div class="card-header">
            <h5 class="card-title mb-0">Defense Completion Statistics</h5>
          </div>
          <div class="card-body">
            <div class="chart chart-sm">
              <fusioncharts type="column2d" width="100%" height="180%" :dataformat="dataFormat"
                :dataSource="pieDatasource">
              </fusioncharts>
            </div>
            
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card flex-fill">
          <div class="card-header">
            <h5 class="card-title mb-0">Students/Users Statistics</h5>
          </div>
          <div class="card-body py-3">
            <div class="chart chart-sm">
              <fusioncharts type="pie3d" :width="width" :height="height" :dataformat="dataFormat"
                :dataSource="dataSource">
              </fusioncharts>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>


<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import axios from 'axios';
import { ref, onMounted, computed, reactive, toRef, nextTick } from 'vue';
import { Link, usePage, router, useForm } from '@inertiajs/vue3'
const type = 'column2d';
const width = '100%';
const height = '200%';
const dataFormat = 'json';

const filteredPieChartData = ref([]);

const dataSource = ref({
  chart: {
    caption: 'Total number of students who were able to have completed their research status.',
    subcaption: 'This includes all the status of the students in the research process.',
    xaxisname: 'Status',
    yaxisname: 'Number of students',
    numbersuffix: '',
    theme: 'fusion',
    // palletecolors: "#af2532"
  },
  data: filteredPieChartData,
})
const handleDateFilter = () => {
  axios.post(`/admin/chart/pie-chart-filter`,{form}).then((res)=>{
    console.log(res.data)
    filteredPieChartData.value = res.data
    console.log(dataSource)
  })
}
const form = reactive({
  from: null,
  to: null,
})



const piedatas = ref([]);

const handlePiechartData = async (e) => {
  const { data, status } = await axios.get(`/admin/courses/${e.target.value}/completed-research-status/${form.from}/${form.to}`)
  piedatas.value = data
};

const pieDatasource = computed(() => {
  return {
    chart: {
      caption: 'Progress Monitoring per Program',
      subcaption: '',
      theme: 'fusion',
      showPercentValues: 0,
      decimals: "0"
    },
    data: piedatas.value, //change default value
    // data: piechartdata.value
  }
})





const fusionChartRef = ref(null);

const onChartInitialized = (chartInstance) => {
  fusionChartRef.value = chartInstance;
};

onMounted(() => {
  // Check if FusionCharts instance is available
  if (fusionChartRef.value) {
    // fusionChartRef.value.setChartData(dataSource);
  }
});

const { courses, barChartData } = defineProps({
  courses: Object,
  barChartData: Object

})

</script>