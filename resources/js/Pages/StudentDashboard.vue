<template>
    <MainLayout>
        <h1 class="h3 mb-3"><strong>Student</strong> Dashboard</h1>

        {{ user }}

    </MainLayout>
</template>

<script setup>
import MainLayout from './../Layouts/MainLayout.vue';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)
const form = computed(() => page.props.auth.user.form)
</script>