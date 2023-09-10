<script>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
export default {
    setup() {
        const form = useForm({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            course_id: '',
            school_year: '',
            year_level: '',
            subject_code: ''
        });
        return { form };
    },
    components: {
        Link
    },
    props: {
        courses: Array, // Define 'courses' as a prop
    }
};
</script>

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
                                    <form @submit.prevent="form.post('/register')">
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
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Course</label>
                                            <select class="form-select mb-3" v-model="form.course_id" name="course_id">
                                                <option value="" selected disabled>Select a course</option>
                                                <option v-for="course in courses" :key="course.id" :value="course.id">{{
                                                    course.name }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">School Year</label>
                                            <input class="form-control form-control-lg" type="text" name="school_year"
                                                placeholder="2023-2024" v-model="form.school_year" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Subject Code</label>
                                            <input class="form-control form-control-lg" type="text" name="subject_code"
                                                placeholder="00000" v-model="form.subject_code" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Year Level</label>
                                            <select class="form-select mb-3" v-model="form.year_level" name="year_level">
                                                <option selected disabled>Select year</option>
                                                <option v-for="year in (form.course_id === 5 ? 5 : 4)" :key="year">{{ year
                                                }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password"
                                                placeholder="Enter password" v-model="form.password" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password_confirmation"
                                                placeholder="Enter password" v-model="form.password_confirmation" />
                                        </div>
                                        <small>
                                            <Link style="color: #af2532" href="/login">Alrady have an account?</Link>
                                        </small>
                                        <div class="text-center mt-3">
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
</main></template>