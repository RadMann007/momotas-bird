<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { Check, XCircle, UploadCloud, Trash2 } from 'lucide-vue-next';
import { onBeforeUnmount } from 'vue';
import { CircuitInterface } from '@/interfaces/custom';

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
    hotel_description: '',
    day: null
});

const submit = () => {
    form.post(route('days.store'));
};

const getImageUrl = (image) => {
    if (image) {
        return URL.createObjectURL(image);
    }
    return '';
};

const handleMainImageChange = (event) => {
    if (form.image) {
        URL.revokeObjectURL(form.image);
    }
    form.image = event.target.files[0];
};


const removeMainImage = () => {
    if (form.image) {
        URL.revokeObjectURL(URL.createObjectURL(form.image));
        form.image = null;
    }
};

onBeforeUnmount(() => {
    if (form.image) {
        URL.revokeObjectURL(URL.createObjectURL(form.image));
    }
});

</script>

<template>
    <Head title="Create New Day" />

    <AuthenticatedLayout>
        <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create a New Day</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Fill in the details below to create a new day for a circuit.</p>
                </div>

                <form @submit.prevent="submit" class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-6">
                        
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Day Information -->
                            <div class="space-y-4">
                                <div>
                                    <label for="circuit_id" class="label text-sm">Circuit</label>
                                    <select id="circuit_id" v-model="form.circuit_id" class="input input-bordered w-full">
                                        <option v-for="circuit in props.circuits" :key="circuit.id" :value="circuit.id">{{ circuit.title }}</option>
                                    </select>
                                    <div v-if="form.errors.circuit_id" class="text-sm text-red-500 mt-1">{{ form.errors.circuit_id }}</div>
                                </div>

                                <div>
                                    <label for="title" class="label text-sm">Title</label>
                                    <input id="title" type="text" v-model="form.title" class="input input-sm input-bordered w-full" placeholder="e.g., Day 1: Arrival in Antananarivo" />
                                    <div v-if="form.errors.title" class="text-sm text-red-500 mt-1">{{ form.errors.title }}</div>
                                </div>

                                <div>
                                    <label for="description" class="label text-sm">Description</label>
                                    <textarea id="description" v-model="form.description" rows="3" class="textarea textarea-sm textarea-bordered w-full" placeholder="Describe the day's activities..."></textarea>
                                    <div v-if="form.errors.description" class="text-sm text-red-500 mt-1">{{ form.errors.description }}</div>
                                </div>
                            </div>

                            <!-- Route & Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="start" class="label text-sm">Starting Point</label>
                                    <input id="start" type="text" v-model="form.start" class="input input-sm input-bordered w-full" placeholder="e.g., Antananarivo" />
                                    <div v-if="form.errors.start" class="text-sm text-red-500 mt-1">{{ form.errors.start }}</div>
                                </div>
                                <div>
                                    <label for="end" class="label text-sm">Ending Point</label>
                                    <input id="end" type="text" v-model="form.end" class="input input-sm input-bordered w-full" placeholder="e.g., Andasibe" />
                                    <div v-if="form.errors.end" class="text-sm text-red-500 mt-1">{{ form.errors.end }}</div>
                                </div>
                                <div>
                                    <label for="distance" class="label text-sm">Distance (km)</label>
                                    <input id="distance" type="number" min="0" v-model="form.distance" class="input input-sm input-bordered w-full" placeholder="e.g., 140" />
                                    <div v-if="form.errors.distance" class="text-sm text-red-500 mt-1">{{ form.errors.distance }}</div>
                                </div>
                                <div>
                                    <label for="day" class="label text-sm">Day Number</label>
                                    <input id="day" type="number" min="1" v-model="form.day" class="input input-sm input-bordered w-full" placeholder="e.g., 1" />
                                    <div v-if="form.errors.day" class="text-sm text-red-500 mt-1">{{ form.errors.day }}</div>
                                </div>
                            </div>

                            <!-- Hotel Information -->
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <h3 class="font-semibold text-md mb-2">Hotel Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="hotel_name" class="label text-sm">Hotel Name</label>
                                        <input id="hotel_name" type="text" v-model="form.hotel_name" class="input input-sm input-bordered w-full" placeholder="e.g., Vakona Forest Lodge" />
                                        <div v-if="form.errors.hotel_name" class="text-sm text-red-500 mt-1">{{ form.errors.hotel_name }}</div>
                                    </div>
                                    <div>
                                        <label for="hotel_description" class="label text-sm">Hotel Description</label>
                                        <textarea id="hotel_description" v-model="form.hotel_description" rows="2" class="textarea textarea-sm textarea-bordered w-full" placeholder="Describe the hotel..."></textarea>
                                        <div v-if="form.errors.hotel_description" class="text-sm text-red-500 mt-1">{{ form.errors.hotel_description }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <!-- Image Uploads -->
                            <div>
                                <label class="label text-sm">Main Image</label>
                                <div class="mt-1 flex justify-center px-4 py-3 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <UploadCloud class="mx-auto h-10 w-10 text-gray-400" />
                                        <div class="flex text-sm text-gray-600">
                                            <label for="main-image-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload a file</span>
                                                <input id="main-image-upload" name="main-image-upload" type="file" class="sr-only" @change="handleMainImageChange">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                                <div v-if="form.errors.image" class="text-sm text-red-500 mt-1">{{ form.errors.image }}</div>
                                <div v-if="form.image" class="mt-3 relative w-40">
                                    <img :src="getImageUrl(form.image)" alt="Main Image Preview" class="w-full h-auto rounded-md shadow-md" />
                                    <button @click="removeMainImage" type="button" class="absolute -top-2 -right-2 btn btn-xs btn-circle btn-error">
                                        <XCircle :size="16" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end items-center gap-4 pt-8">
                        <Link :href="route('circuits.index')" class="btn btn-ghost">Cancel</Link>
                        <button type="submit" class="btn btn-primary" :disabled="form.processing">
                            <Check class="mr-2" /> Create Day
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>