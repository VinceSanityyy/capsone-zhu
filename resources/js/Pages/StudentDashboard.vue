<template>
    <MainLayout>
        <h1 class="h3 mb-3"><strong></strong> Announcements</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Activities</h5>
                    </div>
                    <div class="card-body h-100" v-for="announcement in sortedAnnouncements" :key="announcement.id">
                        <div class="d-flex align-items-start">
                            <img src="https://edukasyon-production.s3.amazonaws.com/uploads/school/avatar/17455/red.jpg"
                                width="36" height="36" class="rounded-circle me-2" alt="Charles Hall">
                            <div class="flex-grow-1">
                                <!-- <small class="float-end text-navy"></small> -->
                                <strong>{{ announcement.user.name }}</strong> posted an <strong>Announcement</strong>
                                <br>
                                <small class="text-muted">{{ announcement.date_created }}</small>
                                <h3>{{announcement.title}}</h3>
                                <div class="border text-sm text-muted p-2 mt-1">
                                    {{ announcement.content }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- {{ announcements }} -->

    </MainLayout>
</template>

<script setup>
import MainLayout from './../Layouts/MainLayout.vue';
import { computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3'
import { useToast } from "vue-toastification";
import Echo from 'laravel-echo';
const toast = useToast();

const page = usePage()
const user = computed(() => page.props.auth.user)
const form = computed(() => page.props.auth.user.form)

const { announcements } = defineProps({
    announcements: Object
});

const sortedAnnouncements = computed(() => {
  return announcements.slice().sort((a, b) => b.id - a.id);
});



</script>