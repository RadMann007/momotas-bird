<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Map, Calendar, Image as ImageIcon } from 'lucide-vue-next'; // Icônes modernes
</script>

<template>
    <Head title="Tableau de bord" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-gray-800">
                Tableau de bord
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    
                    <!-- Circuit -->
                    <Link
                        :href="route('circuits.index')"
                        class="group card bg-base-100 shadow-xl hover:shadow-2xl transition duration-300 border border-gray-100"
                    >
                        <div class="card-body items-center text-center">
                            <Map class="w-12 h-12 text-primary group-hover:scale-110 transition-transform duration-300" />
                            <h3 class="card-title mt-2">Circuits</h3>
                            <p class="text-gray-500">Gérez vos circuits touristiques</p>
                        </div>
                    </Link>

                    <!-- Days -->
                    <Link
                        :href="route('days.index')"
                        class="group card bg-base-100 shadow-xl hover:shadow-2xl transition duration-300 border border-gray-100"
                    >
                        <div class="card-body items-center text-center">
                            <Calendar class="w-12 h-12 text-secondary group-hover:scale-110 transition-transform duration-300" />
                            <h3 class="card-title mt-2">Journées</h3>
                            <p class="text-gray-500">Planifiez chaque journée d’un circuit</p>
                        </div>
                    </Link>

                    <!-- Images -->
                    <Link
                        :href="route('circuits.index')"
                        class="group card bg-base-100 shadow-xl hover:shadow-2xl transition duration-300 border border-gray-100"
                    >
                        <div class="card-body items-center text-center">
                            <ImageIcon class="w-12 h-12 text-accent group-hover:scale-110 transition-transform duration-300" />
                            <h3 class="card-title mt-2">Images</h3>
                            <p class="text-gray-500">Ajoutez et gérez vos images</p>
                        </div>
                    </Link>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
