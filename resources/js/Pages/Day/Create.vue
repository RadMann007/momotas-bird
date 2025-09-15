<script setup lang="ts">
import { CircuitInterface } from '@/interfaces/custom';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { PlusCircle } from 'lucide-vue-next';


const props = defineProps({
    circuits: Array<CircuitInterface>
});

const form = useForm({
    circuit_id: null,
    title: '',
    description: '',
    image: null,
    distance: null,
    start: '',
    end: '',
    hotel_name: '',
    hotel_description: ''
});

const submit = () => {
    // form.post(route('circuits.store'))
    form.post(route('days.store'));
}
</script>

<template>
    <Head title="Create Step" />
    <AuthenticatedLayout>
        <!-- <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Add step</h2>
            </div>
        </template> -->
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8 mt-10">
            <div class="bg-white shadow rounded-lg p-6">
                <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-4">
                    <!-- Circuit -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Circuit</label>
                        <select v-model="form.circuit_id" class="select w-full">
                            <option v-for="step in props.circuits" :key="step.id" :value="step.id">{{ step.title }}</option>
                        </select>
                    </div>

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" v-model="form.title" class="input input-bordered w-full" required />
                    </div>

                    <!-- Distance -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Distance</label>
                            <input type="number" min="0" v-model="form.distance" placeholder="Betafo" class="input input-bordered w-full" required />
                        </div>
                    </div>

                    <!-- Start - End -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Start</label>
                            <input type="text" v-model="form.start" placeholder="Antsirabe" class="input input-bordered w-full" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">End</label>
                            <input type="text" v-model="form.end" placeholder="Betafo" class="input input-bordered w-full" required />
                        </div>
                    </div>

                    <!-- Description -->
                    <textarea v-model="form.description" placeholder="Description" class="textarea textarea-bordered w-full" rows="3"></textarea>

                    <!-- Hotel -->
                    <div class="bg-gray-100 p-2 rounded-md">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Hotel Name</label>
                                <input type="text" v-model="form.hotel_name" class="input input-bordered w-full" required />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mt-2">Hotel description</label>
                            <textarea type="text" v-model="form.hotel_description" class="textarea textarea-bordered w-full" rows="3" required />
                        </div>

                        <!-- Image -->
                        <label class="block text-sm font-medium text-gray-700 mt-2">Image</label>
                        <input
                            type="file"
                            @input="form.image = $event.target.files[0]"
                            class="file-input file-input-bordered w-full mt-1"
                        />
                        <div v-if="form.errors.image" class="text-sm text-red-500 mt-1">
                            {{ form.errors.image }}
                        </div>
                    </div>

                    <div class="modal-action">
                        <button type="submit" class="w-full btn btn-primary" :disabled="form.processing">
                        <PlusCircle class="size-4" /> Add Step</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>