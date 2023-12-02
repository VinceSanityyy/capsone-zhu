<template>
    <div class="wrapper">
        <Sidebar />
        <div class="main">
            <Navbar />
            <main class="content" style = "background-color: #090c29;">
                <div class="container-fluid p-0">
                    <slot />
                </div>
            </main>
            <Footer />
        </div>
    </div>
</template>

<script setup>
import Navbar from './Navbar.vue';
import Sidebar from './Sidebar.vue';
import Footer from './Footer.vue';
import { computed, ref, onMounted, onUnmounted } from 'vue'
import { useToast } from "vue-toastification";
const toast = useToast();

import { usePage } from '@inertiajs/vue3'

const page = usePage()

onMounted(() => {
    window.Echo.connect()
    window.Echo.private(`App.Models.User.${page.props.auth.user.id}`)
      .notification((notification) => {
        console.log(1)
        toast.success(notification.information);
        page.props.notifications.unshift({data:{...notification}})
      });
  });

onUnmounted(() => {
    window.Echo.disconnect()
})
</script>