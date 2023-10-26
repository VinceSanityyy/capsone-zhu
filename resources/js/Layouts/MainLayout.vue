<template>
    <div class="wrapper">
        <Sidebar />
        <div class="main">
            <Navbar />
            <main class="content">
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

import { usePage } from '@inertiajs/vue3'

const page = usePage()
</script>