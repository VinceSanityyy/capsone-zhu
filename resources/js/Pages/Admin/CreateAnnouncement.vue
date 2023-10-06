<template>
    <MainLayout>
        <h1 class="h3 mb-3">New Announcement</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <form @submit.prevent="form.post('/admin/announcements/create')"> -->
                        <form @submit.prevent="handleSubmit">
                            <div class="mb-3">
                                <label class="form-label" for="inputEmail4">Title</label>
                                <input type="text" v-model="form.title" class="form-control" id="inputEmail4" placeholder="">
                                <div v-if="form.errors.title" class="text-danger">{{ form.errors.title
                                            }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="inputEmail4">Content</label>
                                <textarea v-model="form.content" class="form-control" id="inputEmail4"></textarea>
                                <div v-if="form.errors.content" class="text-danger">{{ form.errors.content
                                            }}</div>
                            </div>
                            <div class="mb-3">
                                <!-- Create a flex container and justify content between buttons -->
                                <Link href="/admin/announcements" type="button" class="btn um-button">Back</Link>
                                &nbsp;
                                <button type="submit" class="btn um-button">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { useForm } from '@inertiajs/vue3'
import { Link, router } from '@inertiajs/vue3'
import { useToast } from "vue-toastification";
const toast = useToast();

const form = useForm({
  title: null,
  content: null,
})



const handleSubmit = () => {
  form.post('/admin/announcements/create',{
    onSuccess: () => {
        toast.success("Announcement Created");
    }, onError: (err) => {
        toast.error("Error Creating Announcement");
    },onProgress: progress => {
        console.log(progress)
        // alertify.success('Paper Submitted!');
        // alertify.set('notifier', 'position', 'top-right');
    },})
}

</script>