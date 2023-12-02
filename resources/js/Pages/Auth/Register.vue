<template>
    <main class="d-flex w-100" style = "background-image: url('Images/background.jpg'); background-attachment:fixed; background-size: cover;">
        <div class="container d-flex flex-column">
            <div class="row vh-200">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <h1 class="h2" style = "color:white;">Get started</h1>
                            <p class="lead" style = "color:white;">
                                Please fill out the details
                            </p>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form @submit.prevent="submit">
                                        <div class="mb-3">
                                            <label class="form-label">ID Number</label>
                                            <div class = "input-container">
                                             <i class="icon">
                                                <img src = "Images/id.png">
                                             </i>
                                            <input class="form-control form-control-lg" id = "input-field" type="text" name="id_number"
                                                placeholder="401589" maxlength="6" v-model="form.id_number"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                                        </div>
                                            <div v-if="form.errors.id_number" class="text-danger">{{ form.errors.id_number
                                            }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <div class = "input-container">
                                             <i class="icon">
                                                <img src = "Images/name.png">
                                             </i>
                                            <input class="form-control form-control-lg" id = "input-field" type="text" name="name"
                                                placeholder="John Doe" v-model="form.name" />
                                                </div>
                                            <div v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <div class = "input-container">
                                             <i class="icon">
                                                <img src = "Images/email (2).png">
                                             </i>
                                            <input class="form-control form-control-lg" id = "input-field" type="email" name="email"
                                                placeholder="@umindanao.edu.ph" v-model="form.email" />
                                            </div>
                                            <div v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <div class = "input-container">
                                             <i class="icon">
                                                <img src = "Images/phone.png">
                                             </i>
                                            <input class="form-control form-control-lg" id = "input-field" type="tel" name="phone_number" pattern = "[0-9]*" maxlength = "11"
                                                placeholder="09123456789"  v-model="form.phone_number">
                                            </div>
                                            <div v-if="form.errors.phone_number" class="text-danger">{{
                                                form.errors.phone_number }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Degree Type</label>
                                            <div class = "input-container">
                                             <i class="icon">
                                                <img src = "Images/degree.png">
                                             </i>
                                            <select class="form-select mb-10" id = "input-field" v-model="form.degree_type" name="degree_type">
                                                <option selected disabled>Select type</option>
                                                <option value="masteral">Masters</option>
                                                <option value="doctoral">Doctors</option>

                                            </select>
                                            </div>
                                            <div v-if="form.errors.degree_type" class="text-danger">{{
                                                form.errors.degree_type }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Program</label>
                                            <div class = "input-container">
                                             <i class="icon">
                                                <img src = "Images/program.png">
                                             </i>
                                            <select class="form-select mb-10" id = "input-field" v-model="form.course_id" name="course_id">
                                                <option value="" selected disabled>Select a program</option>
                                                <option v-for="course in courses" :key="course.id" :value="course.id">{{
                                                    course.name }}</option>
                                            </select>
                                            </div>
                                        </div>
                                       
                                        <div class="mb-3">
                                            <label class="form-label">School Year</label>
                                            <div class = "input-container">
                                             <i class="icon">
                                                <img src = "Images/year.png">
                                             </i>
                                            <input class="form-control form-control-lg" id = "input-field" type="text" name="school_year"
                                                placeholder="2023-2024" v-model="form.school_year" />
                                            </div>
                                            <div v-if="form.errors.school_year" class="text-danger">{{
                                                form.errors.school_year }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Enrolled Research Code</label>
                                            <div class = "input-container">
                                             <i class="icon">
                                                <img src = "Images/subject.png">
                                             </i>
                                            <input class="form-control form-control-lg" id = "input-field" type="text" name="subject_code"
                                                placeholder="00000" v-model="form.subject_code" />
                                            </div>
                                            <div v-if="form.errors.subject_code" class="text-danger">{{
                                                form.errors.subject_code }}</div>
                                        </div>
                                       
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class = "input-container">
                                             <i class="icon">
                                                <img src = "Images/password (2).png">
                                             </i>
                                            <input class="form-control form-control-lg" id = "input-field" type="password" name="password"
                                                placeholder="********" v-model="form.password" />
                                        </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <div class = "input-container">
                                             <i class="icon">
                                                <img src = "Images/confirm.png">
                                             </i>
                                            <input class="form-control form-control-lg" id = "input-field" type="password"
                                                name="password_confirmation" placeholder="********"
                                                v-model="form.password_confirmation" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Enrollment form</label>
                                            <input class="form-control form-control-lg" id = "input-field" type="file" name="enrollment_form"
                                                @input="form.enrollment_form = $event.target.files[0]" />
                                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                                {{ form.progress.percentage }}%
                                            </progress>
                                            <div v-if="form.errors.enrollment_form" class="text-danger">{{
                                                'Upload your enrollment form' }}</div>
                                        </div>
                                        <div>
                                            <!-- <div class="form-check align-items-center">
                                                <input id="customControlInline" type="checkbox" v-model="form.terms"
                                                    class="form-check-input" value="remember-me" name="remember-me">
                                                <a style="color:black" @click="showTerms()"
                                                    class="form-check-label text-small" for="customControlInline">Agree
                                                    to terms and conditions</a>
                                            </div>
                                            <div v-if="form.errors.terms" class="text-danger">
                                                {{ 'You must accept the termsand conditions' }}
                                            </div> -->
                                        </div>
                                        <small>
                                            <Link style="color: #af2532" href="/login">Already have an account?</Link>
                                        </small>
                                        <div class="text-center mt-3 d-grid gap-2 mt-3">
                                            <button :disabled="form.processing" type="submit"
                                                style="background: #090c29; color: #fff" class="btn btn-lg">
                                                Sign up
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<style>

.input-field {
  width: 100%;

}
  .input-container {
  display: flex;
  width: 100%;
  height:100%;
  margin-bottom: 15px;
}

/* Style the form icons */
.icon {
  padding: 5px;
  background:#090c29;
  color: white;
  text-align: center;
  height:40px;
  width:10px;
}
  
</style>
<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link, router } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    course_id: '',
    school_year: '',
    // year_level: '',
    subject_code: '',
    id_number: '',
    phone_number: '',
    terms: true,
    enrollment_form: null,
    degree_type: ''
});

import { defineProps } from 'vue'
const props = defineProps({
    courses: Array
});

const submit = () => {
    form.post('/register')
    console.log(form.enrollment_form)
}

const showTerms = () => {
    console.log('show terms');
    alertify
        .alert('Terms and Conditions')
        .setHeader('Terms and Conditions')
        .setContent(`
                    <div>
                        <h2>Confidentiality Pact and Non-Disclosure Agreement</h2>
                        <ol>
                            <li>
                                Access and use of the Student Advising Program (SAP) is a sacred duty of Designated Student Advisers (DSAs) in the service of student development at the University of Mindanao.
                            </li>
                            <li>
                                All information, data, and materials from the personal records of the students are absolutely confidential in nature and must be preserved and protected. Violation of this confidentiality through any form of disclosure and illegal use can result in legal liability.
                            </li>
                            <li>
                                Only official DSAs are authorized to access the SAP. You may proceed to log in if you have the proper authority.
                            </li>
                        </ol>
                    </div>
                `)
        .set('modal', true)
        .set('resizable', true)
        .resizeTo('45%', '35%')
};
</script>