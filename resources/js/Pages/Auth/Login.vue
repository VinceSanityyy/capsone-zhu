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
                .setHeader('Non-Disclosure Agreement')
                .setContent(`
                    <div id = "Agreement">
                        <h2>Confidentiality Pact and Non-Disclosure Agreement</h2><br>
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
                .resizeTo('50%', '43%')
                .set('labels', {ok:'Agree', cancel:'Disagree'})
                .set('onok', function(closeEvent) { router.visit('/register') })
                .set('oncancel', function(closeEvent) {
                    alertify.set('notifier','position', 'top-right');
                    alertify.error('Must agree to continue the sign up process.');
                 });
        }
    },
    unmounted() {
        console.log('unmounted')
        alertify.confirm().destroy()
    }
};


</script>

<style>
#Agreement{

    font-family:Verdana, Geneva, Tahoma, sans-serif;
    font-size: 12px;
}

</style>

<template>
    <main class="d-flex w-100" style = "background-image: url('Images/bg.png'); background-attachment:fixed; background-size: cover;">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <h1 class="h2" style = "color:white;">Welcome</h1>
                            <p class="lead" style = "color:white;">Sign in to your account to continue</p>
                        </div>

                        <div class="card" >
                            <div class="card-body">
                                <div class="m-sm-3" >
                                    <form @submit.prevent="form.post('/login')">
                                        <div class="mb-3">
                                            <label class="form-label" style = "font-family:Sans-serif;color:#090c29;">Email:</label>
                                            <div class = "input-container">
                                             <i class="icon">
                                                <img src = "Images/email (2).png">
                                             </i>
                                            <input class="form-control form-control-lg" id ="input-field" type="email" name="email"
                                            placeholder = "@umindanao.edu.ph" v-model="form.email"/>
                                        
                                           
                                        </div>
                                        <div v-if="form.errors.email">
                                                <p style="color:red">{{ form.errors.email }}</p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" style = "font-family:Sans-serif;color:#090c29;">Password:</label>
                                            <div class = "input-container">
                                             <i class="icon">
                                                <img src = "Images/password (2).png">
                                             </i>
                                            <input class="form-control form-control-lg" id ="input-field"  type="password" name="password" 
                                            placeholder = "********" v-model="form.password"/>
                                            
                                            </div>
                                            <div v-if="form.errors.password">
                                                <p style="color:red">{{ form.errors.password }}</p>
                                            </div>
                                       
                                            <small>
                                                <a @click="showTerms" style="color:#af2532;float:left;" href="#">Don't have an account yet?</a>
                                            </small>
                                            <small>
                                                <Link style="color:#af2532; float: right;" href="/forgot-password">Forgot password?</Link>
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
                                        <br><br>
                                        <div class="text-center mt-3">

                                            <button :disabled="form.processing" type="submit" style="background: #090c29; color: white;  padding: 10px; width: 30%;"
                                                class="btn btn-lg">Sign in<img src = "Images/login.png" style = "padding-left: 5px;height: 17px;"></button>
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
  min-width: 50px;
  text-align: center;
}
/* Style the input fields */
.input-field {
  width: 100%;
}
</style>