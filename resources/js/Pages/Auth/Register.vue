<template>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <h1 class="h2">Get started</h1>
                            <p class="lead">
                                Please fill up the details
                            </p>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form @submit.prevent="submit">
                                        <div class="mb-3">
                                            <label class="form-label">ID Number</label>
                                            <input class="form-control form-control-lg" type="text" name="id_number"
                                                placeholder="401589" v-model="form.id_number"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                                            <div v-if="form.errors.id_number" class="text-danger">{{ form.errors.id_number
                                            }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input class="form-control form-control-lg" type="text" name="name"
                                                placeholder="John Doe" v-model="form.name" />
                                            <div v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" name="email"
                                                placeholder="Enter your email" v-model="form.email" />
                                            <div v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input class="form-control form-control-lg" type="text" name="phone_number"
                                                placeholder="09123456789" v-model="form.phone_number" />
                                            <div v-if="form.errors.phone_number" class="text-danger">{{
                                                form.errors.phone_number }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Program</label>
                                            <select class="form-select mb-3" v-model="form.course_id" name="course_id">
                                                <option value="" selected disabled>Select a program</option>
                                                <option v-for="course in courses" :key="course.id" :value="course.id">{{
                                                    course.name }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">School Year</label>
                                            <input class="form-control form-control-lg" type="text" name="school_year"
                                                placeholder="2023-2024" v-model="form.school_year" />
                                            <div v-if="form.errors.school_year" class="text-danger">{{
                                                form.errors.school_year }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Subject Code</label>
                                            <input class="form-control form-control-lg" type="text" name="subject_code"
                                                placeholder="00000" v-model="form.subject_code" />
                                            <div v-if="form.errors.subject_code" class="text-danger">{{
                                                form.errors.subject_code }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Degree Type</label>
                                            <select class="form-select mb-3" v-model="form.degree_type" name="degree_type">
                                                <option selected disabled>Select type</option>
                                                <option value="masters">Masters</option>
                                                <option value="doctors">Doctors</option>

                                            </select>
                                            <div v-if="form.errors.degree_type" class="text-danger">{{
                                                form.errors.degree_type }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password"
                                                placeholder="Enter password" v-model="form.password" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input class="form-control form-control-lg" type="password"
                                                name="password_confirmation" placeholder="Enter password"
                                                v-model="form.password_confirmation" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Enrollment form</label>
                                            <input class="form-control form-control-lg" type="file" name="enrollment_form"
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
                                            <Link style="color: #af2532" href="/login">Alrady have an account?</Link>
                                        </small>
                                        <div class="text-center mt-3 d-grid gap-2 mt-3">
                                            <button :disabled="form.processing" type="submit"
                                                style="background: #af2532; color: #fff" class="btn btn-lg">
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