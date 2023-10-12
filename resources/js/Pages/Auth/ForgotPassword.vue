<!-- <script>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
export default {
    setup() {
        const form = useForm({
            email: "",
            // password: "",
            // remember: false,
        });
        return { form }
    },
    components: {
        Link
    }
};
</script> -->

<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import { useToast } from "vue-toastification";
const toast = useToast();


const form = useForm({
    email: "",
});

const handleSubmit = () => {
  form.post('/forgot-password',{
    onSuccess: () => {
        toast.success("Password Reset Link sent!");
    }, onError: (err) => {
        toast.error("Something went wrong");
    }})
}

</script>

<template>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <h1 class="h2">Reset password</h1>
                            <p class="lead">Enter your email to reset your password.</p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form @submit.prevent="handleSubmit">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" placeholder="Enter your email" name="email"
                                                 v-model="form.email" />
                                                 <small>
                                                    Enter your email to send the password reset link
                                                 </small>
                                            <div v-if="form.errors.email">
                                                <p style="color:red">{{ form.errors.email }}</p>
                                            </div>

                                        </div>
                                        <!-- <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password"
                                                v-model="form.password" />
                                            <div v-if="form.errors.password">
                                                <p style="color:red">{{ form.errors.password }}</p>
                                            </div>
                                            <small>
                                                <Link style="color: #af2532" href="/register">Don't have an account?</Link>
                                            </small>
                                        </div> -->
                                        <!-- <div>
                                            <label class="form-check">
                                                <input class="form-check-input" type="checkbox" value="remember-me"
                                                    name="remember-me" checked="" v-model="form.remember" />
                                                <span class="form-check-label">
                                                    Remember me next time
                                                </span>
                                            </label>
                                        </div> -->
                                        <div class="text-center mt-3">

                                            <button :disabled="form.processing" type="submit" style="background: #af2532; color: #fff" 
                                                class="btn btn-lg">Send Reset Link</button>
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