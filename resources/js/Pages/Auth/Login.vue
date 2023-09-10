<script>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
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
                            <h1 class="h2">Welcome</h1>
                            <p class="lead">Sign in to your account to continue</p>
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
                                            <div v-if="form.errors.email">
                                                <p style="color:red">{{ form.errors.password }}</p>
                                            </div>
                                            <small>
                                                <Link style="color: #af2532" href="/register">Don't have an account?</Link>
                                            </small>
                                        </div>
                                        <div>
                                            <label class="form-check">
                                                <input class="form-check-input" type="checkbox" value="remember-me"
                                                    name="remember-me" checked="" v-model="form.remember" />
                                                <span class="form-check-label">
                                                    Remember me next time
                                                </span>
                                            </label>
                                        </div>
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