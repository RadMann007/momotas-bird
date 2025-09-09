<script setup lang="ts">
import { CircuitInterface } from '@/interfaces/custom';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';


defineProps({
    circuits: Array<CircuitInterface>
});

const submit = () => {
    //
}
</script>

<template>
    <Head title="Create Day" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Création journée</h2>
                <!-- <Link :href="route('days.create')" class="btn btn-primary">
                    <PlusCircle /> Nouveau
                </Link> -->
            </div>
        </template>
        {{ circuits }}

        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
            <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-6">

            </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>