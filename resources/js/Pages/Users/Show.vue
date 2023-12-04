<template>
    <MainLayout>
        <h1 class="h3 mb-3">User Details</h1>
        <div class="row">
            <div class="col-md-3 col-xl-2">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Settings</h5>
                    </div>

                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account"
                            role="tab" aria-selected="true">
                            Personal Information
                        </a>
                        <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab"
                            aria-selected="false" tabindex="-1">
                            Credentials
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-xl-10">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="account" role="tabpanel">

                        <div class="card">
                            <div class="card-header">

                                <h5 class="card-title mb-0">Personal info</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="mb-3">
                                            <label class="form-label" for="inputFirstName">Name </label>
                                            <input type="text" class="form-control" id="inputFirstName"
                                                v-model="userDetails.name" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputEmail4">Email</label>
                                        <input type="email" class="form-control" id="inputEmail4" placeholder="Email"
                                            v-model="userDetails.email" disabled>
                                    </div>
                                    <div class="mb-3" v-if="userDetails.roles.name !== 'panel' && userDetails.roles.name !== 'adviser' && userDetails.roles.name !== 'faculty'">
                                        <label class="form-label" for="inputAddress">Program</label>
                                        <input type="text" class="form-control" id="inputAddress"
                                            v-model="courseName" disabled>
                                    </div>
                                    <div class="mb-3" v-if="userDetails.roles.name !== 'panel' && userDetails.roles.name !== 'adviser' && userDetails.roles.name !== 'faculty'"> 
                                        <label class="form-label" for="inputAddress2">School year</label>
                                        <input type="text" class="form-control" id="inputAddress2"
                                            v-model="userDetails.school_year" disabled>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6" v-if="userDetails.roles.name !== 'panel' && userDetails.roles.name !== 'adviser' && userDetails.roles.name !== 'faculty'">
                                            <label class="form-label" for="inputCity">Subject Code</label>
                                            <input type="text" class="form-control" id="inputCity"
                                                v-model="userDetails.subject_code" disabled>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="inputZip">Phone </label>
                                            <input type="text" class="form-control" id="inputZip"
                                                v-model="userDetails.phone_number" disabled>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="inputZip">Status</label>
                                            <span :class="userDetails.is_active ? 'badge bg-success' : 'badge bg-danger'"
                                                id="inputZip" style="margin-left: 20px">
                                                {{ userDetails.is_active ? 'Approved' : 'Waiting for approval' }}
                                            </span>
                                        </div>
                                    </div>
                                    <button type="button" @click="handleUser(userDetails)" class="btn um-button">
                                        {{ userDetails.is_active ? 'Deactivate User' : 'Confirm User' }}
                                    </button>
                                </form>

                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <div class="card">
   
                            <img class="card-img-top" :src="userFormFilePath.file_path">
                            <div class="card-header">
                                <h5 class="card-title mb-0"></h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Please check the form before accepting the user (if student).</p>
                                <!-- <a href="#" class="card-link">Download</a> -->
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
import { defineProps, ref, onMounted, reactive, computed, toRaw } from 'vue';
import { Link, router } from '@inertiajs/vue3'
import { useToast } from "vue-toastification";
const toast = useToast();

const { userDetails } = defineProps({
    userDetails: Object
})
const rolesToHide = ['panel', 'adviser', 'faculty'];

const courseName = computed(() => {
  return userDetails.course ? userDetails.course.name : 'Not Applicable';
});


const userFormFilePath = computed(() => userDetails.form || '');

const handleUser = ref((user) => {
    const actionTitle = user.is_active ? 'Deactivate User' : 'Confirm User';
    const actionMessage = user.is_active ? `Deactivate ${user.name} ?` : `Accept ${user.name} ?`;

    alertify.confirm(actionTitle, actionMessage, () => {
        router.put(`/admin/users/${user.id}/${user.is_active ? 'deactivate' : 'approve'}`)
        toast.success('User Status Updated');
    }, () => {
        console.log('cancel')
    });
});

</script>


<style scoped>
.list-group-item.active {
    background-color: #af2532;
    border-color: #af2532;
    color: white;
    z-index: 2;
}
</style>