<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PlusCircle } from 'lucide-vue-next';

</script>

<template>
    <Head title="Days"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Liste</h2>
                <Link :href="route('days.create')" class="btn btn-primary">
                    <PlusCircle /> Nouveau
                </Link>
            </div>
        </template>
    </AuthenticatedLayout>
</template>