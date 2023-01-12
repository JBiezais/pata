<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import CreateUserForm from "@/Components/CreateUserForm.vue";

</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <CreateUserForm></CreateUserForm>
    </GuestLayout>
</template>
