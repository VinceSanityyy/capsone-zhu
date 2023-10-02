<template>
    <MainLayout>
        <h1 class="h3 mb-3">My Submissions</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Research Title details</h5>
                        <h6 class="card-subtitle text-muted">You cannot update some of the fields when you already submitted your title</h6>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="submitResearch">
                            <div class="mb-3">
                                <label class="form-label" for="inputAddress">Research Title</label>
                                <input :disabled="alreadySubmitted" v-model="form.title" type="text" class="form-control" id="inputAddress"
                                    placeholder="">
                                <div data-lastpass-icon-root="true"
                                    style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;">
                                </div>
                                <div v-if="form.errors.title" class="text-danger">{{
                                    form.errors.title }}</div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="inputAddress">Adviser</label>
                                <select :disabled="alreadySubmitted"  v-model="form.adviser" class="form-control mb-3">
                                    <option selected="">Open this select menu</option>
                                    <option :value="adviser.id" v-for="adviser in advisers" :key="adviser.id">{{
                                        adviser.name }}</option>
                                </select>
                                <div v-if="form.errors.adviser" class="text-danger">{{
                                    form.errors.adviser }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="inputAddress">Status</label>
                                    <select v-model="form.status" class="form-control mb-3">
                                        <option selected="">Open this select menu</option>
                                        <option value="title_defense">For Title Defense</option>
                                        <option value="outline_defense">For Outline Defense</option>
                                        <option value="final_defense">For Final Defense</option>
                                        <option value="quality_checking">For Quality Checking</option>
                                        <option value="for_scheduling">For Scheduling</option>
                                    </select>
                                </div>
                                <div v-if="form.errors.status" class="text-danger">{{
                                    form.errors.status }}</div>
                                <div class="col-md-6">

                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">File</label>
                                    <input @input="form.document = $event.target.files[0]" type="file" class="form-control"
                                        name="" id="" aria-describedby="helpId" placeholder="">
                                    <div v-if="form.errors.document" class="text-danger">{{
                                        form.errors.document }}</div>
                                    <small id="helpId" class="form-text text-muted">Pdf only</small>
                                </div>

                                <div class="mb-3" v-if="form.status === 'for_scheduling'">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="endorsementInput">
                                                Attach Endorsement
                                                <input type="file" id="endorsementInput" class="form-control um-button"
                                                    @input="form.endorsement = $event.target.files[0]">
                                            </label>
                                            <div v-if="form.errors.endorsement" class="text-danger">{{
                                                form.errors.endorsement }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="receiptInput">
                                                Attach Receipt
                                                <input type="file" id="receiptInput" class="form-control um-button"
                                                    @input="form.receipt = $event.target.files[0]">
                                            </label>
                                            <div v-if="form.errors.receipt" class="text-danger">{{
                                                form.errors.receipt }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button v-show="alreadySubmitted == false" type="submit" class="btn um-button">Submit</button>
                            <button v-show="alreadySubmitted" type="submit" class="btn um-button">Update Status</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3'

const status = ref('');

// const form = useForm({
//     title: null,
//     adviser: '',
//     status: null,
//     document: null,
//     endorsement: null,
//     receipt: null
// })

const form = ref({
  title: alreadySubmitted ? studentPaper.title : '',
  adviser: alreadySubmitted ? studentPaper.adviser_id : null,
  status: alreadySubmitted ? studentPaper.status : '',
  document: null,
  endorsement: null,
  receipt: null,
  errors: {}, // Define the errors object for form validation
});



const { advisers, alreadySubmitted, studentPaper } = defineProps({
    advisers: Object,
    alreadySubmitted: Boolean,
    studentPaper: Object
})

const submitResearch = async () => {
    try {
        await router.post('/student/my-submissions/submit',form, {
            onSuccess: () => {
                alertify.success('Paper Submitted!');
                alertify.set('notifier', 'position', 'top-right');
            },
            onError: (errors) => {
                console.error(errors); // Log the errors for debugging
                alertify.set('notifier', 'position', 'top-right');
            },
        });
    } catch (error) {
        console.error(error); // Log the error for debugging
        alertify.error('An error occurred while changing the password.');
    }
};

</script>