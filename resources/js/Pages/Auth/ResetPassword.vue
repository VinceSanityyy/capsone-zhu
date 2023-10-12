<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import { useToast } from "vue-toastification";
const toast = useToast();

const form = useForm({
    password_confirmation: "",
    password: "",
    token: token,
    email: email
});

const {token, email} = defineProps({
    token: String,
    email: String
});

const handleSubmit = () => {
  form.post('/reset-password',{
    onSuccess: () => {
        toast.success("Password Updated");
    }, onError: (err) => {
        err.email ? toast.error(err.email) : toast.error("Error Updating Password");
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
                            <h1 class="h2">Enter your new password</h1>
                            <p class="lead">Enter and confirm your password</p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form @submit.prevent="handleSubmit">
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password"
                                                 v-model="form.password" />
                                            <div v-if="form.errors.password">
                                                <p style="color:red">{{ form.errors.password }}</p>
                                            </div>

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password_confirmation"
                                                v-model="form.password_confirmation" />
                                            <div v-if="form.errors.password_confirmation">
                                                <p style="color:red">{{ form.errors.password_confirmation }}</p>
                                            </div>
                                            <!-- <small>
                                                <Link style="color: #af2532" href="/register">Don't have an account?</Link>
                                            </small> -->
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
                                        <div class="text-center mt-3">

                                            <button :disabled="form.processing" type="submit" style="background: #af2532; color: #fff" 
                                                class="btn btn-lg">Reset</button>
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