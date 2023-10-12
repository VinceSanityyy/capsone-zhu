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
                        <!-- <div class="stepper-wrapper">
                            <div :class="['stepper-item', studentPaper.status === 'title_defense' ? 'active' : 'completed']">
                                <div class="step-counter"></div>
                                <div class="step-name">For Title Defense</div>
                            </div>
                            <div
                                :class="['stepper-item', studentPaper.status === 'outline_defense' ? 'active' : '']">
                                <div class="step-counter"></div>
                                <div class="step-name">Outline Defense</div>
                            </div>
                            <div :class="['stepper-item', studentPaper.status === 'final_defense' ? 'active' : '']">
                                <div class="step-counter"></div>
                                <div class="step-name">Final Defense</div>
                            </div>
                            <div
                                :class="['stepper-item', studentPaper.status === 'quality_checking' ? 'active' : '']">
                                <div class="step-counter"></div>
                                <div class="step-name">Quality Checking</div>
                            </div>
                        </div> -->
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
                                            <div class="col-md-6">
                                                <label class="form-label" for="inputAddress">Status</label>
                                                <select v-model="form.status" class="form-control mb-3">
                                                    <option selected="" disabled>Open this select menu</option>
                                                    <option value="title_defense">For Title Defense</option>
                                                    <option value="outline_defense">For Outline Defense</option>
                                                    <option value="final_defense">For Final Defense</option>
                                                    <option value="quality_checking">For Quality Checking</option>
                                                </select>
                                            </div>
                                            <div v-if="form.errors.status" class="text-danger">{{
                                                form.errors.status }}</div>
                                            <!-- <div class="col-md-6">
                                                <label class="form-label" for="inputAddress">For Scheduling?</label>
                                                <select :disabled="!studentPaper.is_approved_by_adviser" v-model="form.for_scheduling" class="form-control mb-3">
                                                    <option selected="" disabled>Open this select menu</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div> -->
                                            <div class="col-md-6">
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

                                            <div class="mb-3" v-if="form.for_scheduling === 'yes'">
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
                                                    <div class="col-md-6">
                                                        <label for="receiptInput">
                                                            Attach Receipt
                                                            <input type="file" id="receiptInput"
                                                                class="form-control um-button"
                                                                @input="form.receipt = $event.target.files[0]">
                                                        </label>
                                                        <div v-if="form.errors.receipt" class="text-danger">{{
                                                            form.errors.receipt }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button v-show="alreadySubmitted == false" type="submit"
                                            class="btn um-button">Submit</button>
                                        <button v-show="alreadySubmitted" type="submit" class="btn um-button">Update
                                            Status</button>

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
                                    <h4 class="tab-title">Forms Attached</h4>
                                    <hr>
                                    <ul>
                                        <li>
                                            <a :href="studentPaper?.endorsement?.[0]?.file_path ?? '#'" target="_blank" class="btn um-button">
                                                Endorsement Form &nbsp;
                                                <i class="bi bi-cloud-arrow-down"></i>
                                            </a>
                                        </li>
                                        <br>
                                        <li>
                                            <button class="btn um-button">
                                                Other Form &nbsp;
                                                <i class="bi bi-cloud-arrow-down"></i>
                                            </button>
                                        </li>
                                        <br>
                                        <li>
                                            <button class="btn um-button">
                                                Receipt Form &nbsp;
                                                <i class="bi bi-cloud-arrow-down"></i>
                                            </button>

                                        </li>
                                    </ul>
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
import { ref, reactive } from 'vue';
import { useForm, router } from '@inertiajs/vue3'
import { useToast } from "vue-toastification";
const toast = useToast();


const status = ref('');

const form = reactive({
    title: alreadySubmitted ? studentPaper.title : '',
    adviser_id: alreadySubmitted ? studentPaper.adviser_id : null,
    status: alreadySubmitted ? studentPaper.status : '',
    document: null,
    endorsement: null,
    receipt: null,
    errors: {},
    for_scheduling: 'no' //default
});

// const studentPaper = ref(studentPaper.status ?? null);

const { advisers, alreadySubmitted, studentPaper, adviserComments, panelMemberComments, adminComments, endorsement } = defineProps({
    advisers: Object,
    alreadySubmitted: Boolean,
    studentPaper: Object,
    adviserComments: Object,
    panelMemberComments: Object,
    adminComments: Object,
    endorsement: String
})

const submitResearch = async () => {
    try {
        await router.post('/student/my-submissions/submit', form, {
            onSuccess: () => {
                toast.success('Paper Submitted!');
            },
            onError: (err) => {
                form.errors = err
                toast.error('Error Submitting Paper!');
            },
        });
    } catch (error) {
        console.error(error); // Log the error for debugging
    }
};

</script>


<style scoped>
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