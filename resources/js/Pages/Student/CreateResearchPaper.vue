<template>
    <MainLayout>
        <h1 class="h3 mb-3">My Submissions</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Research Title details</h5>
                        <h6 class="card-subtitle text-muted">You cannot update some of the fields when you already submitted
                            your title</h6>
                    </div>
                    <div class="card-body">
                        <div class="stepper-wrapper">
                            <div :class="['stepper-item', { 'active': paperStatus === 1 }, { 'completed': paperStatus >= 1 }]">
                                <div class="step-counter"></div>
                                <div class="step-name">For Title Defense</div>
                            </div>
                            <div :class="['stepper-item', { 'active': paperStatus === 2 }, { 'completed': paperStatus > 2 }]">
                                <div class="step-counter"></div>
                                <div class="step-name">Outline Defense</div>
                            </div>
                            <div :class="['stepper-item', { 'active': paperStatus === 3 }, { 'completed': paperStatus > 3 }]">
                                <div class="step-counter"></div>
                                <div class="step-name">Final Defense</div>
                            </div>
                            <div :class="['stepper-item', { 'active': paperStatus === 4 }, { 'completed': paperStatus > 4 }]">
                                <div class="step-counter"></div>
                                <div class="step-name">Final Revision</div>
                            </div>
                            <div :class="['stepper-item', { 'active': paperStatus === 5 }, { 'completed': paperStatus > 5 }]">
                                <div class="step-counter"></div>
                                <div class="step-name">Quality Checking</div>
                            </div>
                            <div :class="['stepper-item', { 'active': paperStatus === 6 }, { 'completed': paperStatus > 6 }]">
                                <div class="step-counter"></div>
                                <div class="step-name">Final Checking</div>
                            </div>
                            <div :class="['stepper-item', { 'active': paperStatus === 7 }, { 'completed': paperStatus > 7 }]">
                                <div class="step-counter"></div>
                                <div class="step-name">Final Submission</div>
                            </div>
                            <div :class="['stepper-item', { 'active': paperStatus === 8 }, { 'completed': paperStatus >= 8 }]">
                                <div class="step-counter"></div>
                                <div class="step-name">Completed</div>
                            </div>
                        </div>
                        <div class="tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation"><a class="nav-link active" href="#tab-1"
                                        data-bs-toggle="tab" role="tab" aria-selected="true">Overview</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-2"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Panel
                                        Comments</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-3"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Adviser
                                        Comments</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-4"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Admin
                                        Comments</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-5"
                                        data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                                        Forms</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tab-1" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Research Paper Overview</h4>
                                    <hr>
                                    <form @submit.prevent="submitResearch">
                                        <div class="mb-3">
                                            <label class="form-label" for="inputAddress">Research Title</label>
                                            <input :disabled="alreadySubmitted" v-model="form.title" type="text"
                                                class="form-control" id="inputAddress" placeholder="">
                                            <div data-lastpass-icon-root="true"
                                                style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;">
                                            </div>
                                            <div v-if="form.errors.title" class="text-danger">{{
                                                form.errors.title }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="inputAddress">Adviser</label>
                                            <select :disabled="alreadySubmitted" v-model="form.adviser_id"
                                                class="form-control mb-3">
                                                <option selected="">Open this select menu</option>
                                                <option :value="adviser.id" v-for="adviser in advisers" :key="adviser.id">{{
                                                    adviser.name }}</option>
                                            </select>
                                            <div v-if="form.errors.adviser_id" class="text-danger">{{
                                                form.errors.adviser_id }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-4"
                                                    v-if="['final_submission', 'completed'].includes(studentPaper?.status)">
                                                    <h3>Final submission checklist status</h3>
                                                    <div>
                                                        <label class="form-check" v-for="checklist in checkLists"
                                                            :key="checklist.id">
                                                            <input :checked="studentPaper[checklist.value]"
                                                                class="form-check-input" type="checkbox"
                                                                :value="checklist.value" :disabled="true">
                                                            <span class="form-check">
                                                                {{ checklist.label }}
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                Current Status: <strong v-if="form.status !== ''">{{ studentPaper?.status
                                                }}</strong>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label style="font-weight: bold;"> Adviser Approval:</label>
                                                <span v-if="studentPaper?.is_approved_by_adviser == 1"
                                                    class="badge bg-success">Approved</span>
                                                <span v-if="studentPaper?.is_approved_by_adviser == 0"
                                                    class="badge bg-danger">Waiting for approval</span>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="form-label">Select status:</label>
                                                <select v-model="form.status" class="form-control mb-3">
                                                    <option selected="" disabled>Open this select menu</option>
                                                    <option value="title_defense">For Title Defense</option>
                                                    <option value="outline_defense">For Outline Defense</option>
                                                    <option value="final_defense">For Final Defense</option>
                                                    <option value="final_revision">For Final Revision</option>
                                                    <option value="quality_checking">For Quality Checking</option>
                                                    <option value="final_checking">Final Checking</option>

                                                </select>
                                            </div>
                                            <div v-if="form.errors.status" class="text-danger">{{
                                                form.errors.status }}</div>

                                            <div class="col-md-6"
                                                v-if="['title_defense', 'outline_defense', 'final_defense'].includes(form.status)">
                                                <label class="form-label" for="inputAddress">For Scheduling?</label>
                                                <select :disabled="!studentPaper || !studentPaper.is_approved_by_adviser"
                                                    v-model="form.for_scheduling" class="form-control mb-3">
                                                    <option disabled value="">Open this select menu</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="" class="form-label">File</label>
                                                <input @input="form.document = $event.target.files[0]" type="file"
                                                    class="form-control" name="" id="" aria-describedby="helpId"
                                                    placeholder="">
                                                <div v-if="form.errors.document" class="text-danger">{{
                                                    form.errors.document }}</div>
                                                <small id="helpId" class="form-text text-muted">Pdf only</small>
                                            </div>

                                            <div class="mb-3"
                                                v-if="form.for_scheduling === 'yes' || form.status == 'final_checking'">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="endorsementInput">
                                                            Attach Endorsement
                                                            <input type="file" id="endorsementInput"
                                                                class="form-control um-button"
                                                                @input="form.endorsement = $event.target.files[0]">
                                                        </label>
                                                        <div v-if="form.errors.endorsement" class="text-danger">{{
                                                            form.errors.endorsement }}</div>
                                                    </div>
                                                    <div class="col-md-6" v-if="form.status !== 'final_checking'">
                                                        <label for="receiptInput">
                                                            Attach Receipt
                                                            <input type="file" id="receiptInput"
                                                                class="form-control um-button"
                                                                @input="form.receipt = $event.target.files[0]">
                                                        </label>
                                                        <div v-if="form.errors.receipt" class="text-danger">{{
                                                            form.errors.receipt }}</div>
                                                    </div>
                                                    <div class="col-md-6">

                                                    </div>
                                                    <div class="col-md-3 mt-3" v-if="form.status !== 'final_checking'">
                                                        <label for="receiptInput">
                                                            Amount
                                                            <input v-model="form.amount" type="text" id="receiptInput"
                                                                class="form-control">
                                                        </label>
                                                        <div v-if="form.errors.amount" class="text-danger">{{
                                                            form.errors.amount }}</div>
                                                    </div>
                                                    <div class="col-md-3 mt-3" v-if="form.status !== 'final_checking'">
                                                        <label for="receiptInput">
                                                            Reference Number
                                                            <input v-model="form.reference_number" type="text"
                                                                id="receiptInput" class="form-control">
                                                        </label>
                                                        <div v-if="form.errors.reference_number" class="text-danger">{{
                                                            form.errors.reference_number }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4"  v-if="studentPaper?.status == 'quality_checking' && studentPaper?.plagiarism_counter >= 3">
                                            <div class="col-md-6">
                                                <label for="receiptInput">
                                                    Attach Receipt since you reached the maximum plagiarism count
                                                    <input type="file" id="receiptInput" class="form-control um-button" required
                                                        @input="form.receipt = $event.target.files[0]">
                                                </label>
                                                <div v-if="form.errors.receipt" class="text-danger">{{
                                                    form.errors.receipt }}</div>
                                            </div>
                                            <div class="col-md-6">

                                            </div>
                                            <div class="col-md-3 mt-3" >
                                                <label for="receiptInput">
                                                    Amount
                                                    <input v-model="form.amount" type="text" id="receiptInput" required
                                                        class="form-control">
                                                </label>
                                                <div v-if="form.errors.amount" class="text-danger">{{
                                                    form.errors.amount }}</div>
                                            </div>
                                            <div class="col-md-3 mt-3">
                                                <label for="receiptInput">
                                                    Reference Number
                                                    <input v-model="form.reference_number" type="text" id="receiptInput" required
                                                        class="form-control">
                                                </label>
                                                <div v-if="form.errors.reference_number" class="text-danger">{{
                                                    form.errors.reference_number }}</div>
                                            </div>
                                        </div>
                                        <button v-show="alreadySubmitted == false" type="submit"
                                            class="btn um-button">Submit</button>
                                        <button v-show="alreadySubmitted" :disabled="studentPaper?.status == 'completed'"
                                            type="submit" class="btn um-button">Update
                                            Status</button>
                                        <br>
                                        <!-- <small>If your paper's status is completed, you cannot motify or update it.</small> -->
                                    </form>
                                    <br>
                                    {{ form }}
                                </div>

                                <div class="tab-pane" id="tab-2" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Panel Comments</h4>
                                    <hr>
                                    <div v-for="comment in panelMemberComments" :key="comment.id" class="card-body h-100">
                                        <hr>
                                        <div class="d-flex align-items-start">
                                            <img src="https://edukasyon-production.s3.amazonaws.com/uploads/school/avatar/17455/red.jpg"
                                                width="36" height="36" class="rounded-circle me-2" alt="Charles Hall">
                                            <div class="flex-grow-1">
                                                <small class="float-end text-navy">30m ago</small>
                                                <strong>{{ comment.user.name }}</strong> wrote a comment <strong>
                                                    on the study {{ studentPaper.title }}</strong><br>
                                                <small class="text-muted">{{ comment.date_created }}</small>

                                                <div class="border text-sm text-muted p-2 mt-1">
                                                    <div v-html="comment.comment"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-3" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Adviser Comments</h4>
                                    <hr>
                                    <div v-for="comment in adviserComments" :key="comment.id" class="card-body h-100">
                                        <div class="card-body h-50">

                                            <hr>
                                            <div class="d-flex align-items-start">
                                                <img src="https://edukasyon-production.s3.amazonaws.com/uploads/school/avatar/17455/red.jpg"
                                                    width="36" height="36" class="rounded-circle me-2" alt="Charles Hall">
                                                <div class="flex-grow-1">
                                                    <small class="float-end text-navy"></small>
                                                    <strong>{{ comment.user.name }}</strong> wrote a comment <strong>
                                                        on the study {{ studentPaper.title }}</strong><br>
                                                    <small class="text-muted">{{ comment.date_created }}</small>

                                                    <div class="border text-sm text-muted p-2 mt-1">
                                                        <div v-html="comment.comment"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-4" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Admin Comments</h4>
                                    <hr>
                                    <div v-for="comment in adminComments" :key="comment.id" class="card-body h-100">
                                        <div class="card-body h-50">

                                            <hr>
                                            <div class="d-flex align-items-start">
                                                <img src="https://edukasyon-production.s3.amazonaws.com/uploads/school/avatar/17455/red.jpg"
                                                    width="36" height="36" class="rounded-circle me-2" alt="Charles Hall">
                                                <div class="flex-grow-1">
                                                    <small class="float-end text-navy"></small>
                                                    <strong>{{ comment.user.name }}</strong> wrote a comment <strong>
                                                        on the study {{ studentPaper.title }}</strong><br>
                                                    <small class="text-muted">{{ comment.date_created }}</small>

                                                    <div class="border text-sm text-muted p-2 mt-1">
                                                        <div v-html="comment.comment"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-5" role="tabpanel">
                                    <br>
                                    <h4 class="tab-title">Forms Attached (by adviser)</h4>
                                    <hr>
                                    <DataTable class="display" ref="table">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Stage Attached</th>
                                                <th>Date Submitted</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="endorsement in attachedPanelEndorsements" :key="endorsement.id">
                                                <td>Endorsement Form</td>
                                                <td>{{ endorsement.stage_submitted }}</td>
                                                <td>{{ endorsement.created_at }}</td>
                                                <td>
                                                    <a :href="endorsement.file_path" class="btn btn-sm um-button"
                                                        target="_blank">Download</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </DataTable>
                                </div>
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
import { ref, reactive, computed, watch } from 'vue';
import { useForm, router } from '@inertiajs/vue3'
import { useToast } from "vue-toastification";
import DataTable from 'datatables.net-vue3';

const toast = useToast();


const status = ref('');

const form = reactive({
    title: props.alreadySubmitted ? props.studentPaper.title : '',
    adviser_id: props.alreadySubmitted ? props.studentPaper.adviser_id : null,
    status: props.alreadySubmitted ? props.studentPaper.status : '',
    document: null,
    endorsement: null,
    receipt: null,
    errors: {},
    for_scheduling: 'no', //default
    reference_number: '',
    amount: '',
    quality_checking: false
});

const props = defineProps({
    advisers: Object,
    alreadySubmitted: Boolean,
    studentPaper: Object,
    adviserComments: Object,
    panelMemberComments: Object,
    adminComments: Object,
    endorsement: String,
    endorsement_forms: Object,
    attachedPanelEndorsements: Object
})

const checkLists = ref([
    {
        label: '1 copy of the final manuscript in book form (hardbound)',
        checked: props.studentPaper?.has_submitted_manuscript,
        value: 'has_submitted_manuscript'
    },
    {
        label: '3 CDs containing the final manuscript (in Word and PDF format)',
        checked: props.studentPaper?.has_submitted_cd,
        value: 'has_submitted_cd'
    },
    {
        label: 'Final adviser’s payment receipt',
        checked: props.studentPaper?.has_submitted_final_receipt,
        value: 'has_submitted_final_receipt'
    },
    {
        label: '1 printed copy of the published paper',
        checked: props.studentPaper?.has_submitted_printed_materials,
        value: 'has_submitted_printed_materials'
    },
]);

// const { advisers,
//     alreadySubmitted,
//     studentPaper,
//     adviserComments,
//     panelMemberComments,
//     adminComments,
//     endorsement,
//     endorsement_forms,
//     attachedPanelEndorsements } =
//     defineProps({
//         advisers: Object,
//         alreadySubmitted: Boolean,
//         studentPaper: Object,
//         adviserComments: Object,
//         panelMemberComments: Object,
//         adminComments: Object,
//         endorsement: String,
//         endorsement_forms: Object,
//         attachedPanelEndorsements: Object
//     })

const submitResearch = async () => {
    await router.post('/student/my-submissions/submit', form, {
        onSuccess: () => {
            toast.success('Paper Submitted!');
        },
        onError: (err) => {
            console.log(err)
            form.errors = err
            toast.error('Error Submitting Paper!');
        },
    });
};

const paperStatus = computed(() => {
    return {
        title_defense: 1,
        outline_defense: 2,
        final_defense: 3,
        final_revision: 4,
        quality_checking: 5,
        final_checking: 6,
        final_submission: 7,
        completed: 8
    }[props.studentPaper?.status]
});

</script>


<style scoped>
@import 'datatables.net-dt';

.stepper-wrapper {
    margin-top: auto;
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.stepper-item {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;

    @media (max-width: 768px) {
        font-size: 12px;
    }
}

.stepper-item::before {
    position: absolute;
    content: "";
    border-bottom: 2px solid #ccc;
    width: 100%;
    top: 20px;
    left: -50%;
    z-index: 2;
}

.stepper-item::after {
    position: absolute;
    content: "";
    border-bottom: 2px solid #ccc;
    width: 100%;
    top: 20px;
    left: 50%;
    z-index: 2;
}

.stepper-item .step-counter {
    position: relative;
    z-index: 5;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #ccc;
    margin-bottom: 6px;
}

.stepper-item.active {
    font-weight: bold;
}

.stepper-item.completed .step-counter {
    background-color: #af2532;
}

.stepper-item.completed::after {
    position: absolute;
    content: "";
    border-bottom: 2px solid #af2532;
    width: 100%;
    top: 20px;
    left: 50%;
    z-index: 3;
}

.stepper-item:first-child::before {
    content: none;
}

.stepper-item:last-child::after {
    content: none;
}
</style>