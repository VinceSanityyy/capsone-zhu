<script>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
// import { unmounted } from 'vue'
export default {
    setup() {
        const form = useForm({
            email: "",
            password: "",
            remember: false,
        });
        return { form }
    },
    components: {
        Link
    },
    methods: {
        showTerms() {
            alertify
                .confirm('Terms and Conditions')
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
                .set('labels', {ok:'Agree', cancel:'Disagree'})
                .set('onok', function(closeEvent) { router.visit('/register') })
                .set('oncancel', function(closeEvent) {
                    alertify.set('notifier','position', 'top-right');
                    alertify.error('Accept the terms and conditions to continue');
                 });
        }
    },
    unmounted() {
        console.log('unmounted')
        alertify.confirm().destroy()
    }
};
</script>

<template>
    <main class="d-flex w-100" style = "background-image: url('Images/background.jpg'); background-attachment:fixed; background-size: cover;">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <h1 class="h2" style = "color:white;">Welcome</h1>
                            <p class="lead" style = "color:white;">Sign in to your account to continue</p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form @submit.prevent="form.post('/login')">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" name="email"
                                                placeholder="Enter your email" v-model="form.email" />
                                            <div v-if="form.errors.email">
                                                <p style="color:red">{{ form.errors.email }}</p>
                                            </div>

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password"
                                                placeholder="Enter your password" v-model="form.password" />
                                            <div v-if="form.errors.password">
                                                <p style="color:red">{{ form.errors.password }}</p>
                                            </div>
                                            <br>
                                            <small>
                                                <a @click="showTerms" style="color: #af2532" href="#">Don't have an account?</a>
                                            </small>
                                            <small>
                                                <Link style="color: #af2532; float: right;" href="/forgot-password">Forgot password?</Link>
                                            </small>
                                        </div>
                                        <!-- <div>
                                            <label class="form-check">
                                                <input class="form-check-input" type="checkbox" value="remember-me"
                                                    name="remember-me" checked="" v-model="form.remember" />
                                                <span class="form-check-label">
                                                    Remember me next time
                                                </span>
                                            </label>
                                        </div> -->
                                        <br>
                                        <div class="text-center mt-3">

                                            <button :disabled="form.processing" type="submit" style="background: #af2532; color: #fff" 
                                                class="btn btn-lg">Sign in</button>
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