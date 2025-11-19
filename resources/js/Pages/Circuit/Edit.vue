 <script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { Check, XCircle, UploadCloud, Trash2 } from 'lucide-vue-next';
import { onBeforeUnmount } from 'vue';

const props = defineProps({
    circuit: Array
})

const form = useForm({
    _method: 'put',
    title: props.circuit.title,
    duration: props.circuit.duration,
    description: props.circuit.description,
    image: null,
    images: [],
    start: props.circuit.start,
    end: props.circuit.end,
    distance: props.circuit.distance,
    truck_disponibility: props.circuit.truck_disponibility,
    price_3_pers: props.circuit.price_3_pers,
    price_6_pers: props.circuit.price_6_pers,
    price_max_pers: props.circuit.price_max_pers,
});

const submit = () => {
    form.post(route('circuits.update', props.circuit.id));
    // form.post(route('circuits.store'));
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

const handleImagesChange = (event) => {
    const newFiles = Array.from(event.target.files);
    form.images = form.images.concat(newFiles);
    event.target.value = null;
};

const removeImage = (index) => {
    const imageToRemove = form.images[index];
    if (imageToRemove) {
        URL.revokeObjectURL(URL.createObjectURL(imageToRemove));
    }
    form.images.splice(index, 1);
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
    form.images.forEach(image => {
        URL.revokeObjectURL(URL.createObjectURL(image));
    });
});

</script>

<template>
    <Head title="Edit Circuit" />
    <AuthenticatedLayout>
        <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit: {{ props.circuit.title }}</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Fill in the details below to create a new birdwatching circuit.</p>
                </div>

                <form @submit.prevent="submit" class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-6">
                        
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Circuit Information -->
                            <div class="space-y-4">
                                <div>
                                    <label for="title" class="label text-sm">Title</label>
                                    <input id="title" type="text" v-model="form.title" class="input input-sm input-bordered w-full" placeholder="e.g., Madagascar Endemic Birds Quest" />
                                    <div v-if="form.errors.title" class="text-sm text-red-500 mt-1">{{ form.errors.title }}</div>
                                </div>

                                <div>
                                    <label for="description" class="label text-sm">Description</label>
                                    <textarea id="description" v-model="form.description" rows="3" class="textarea textarea-sm textarea-bordered w-full" placeholder="Describe the circuit..."></textarea>
                                    <div v-if="form.errors.description" class="text-sm text-red-500 mt-1">{{ form.errors.description }}</div>
                                </div>
                            </div>

                            <!-- Route & Duration -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="start" class="label text-sm">Starting Point</label>
                                    <input id="start" type="text" v-model="form.start" class="input input-sm input-bordered w-full" placeholder="e.g., Antananarivo" />
                                    <div v-if="form.errors.start" class="text-sm text-red-500 mt-1">{{ form.errors.start }}</div>
                                </div>
                                <div>
                                    <label for="end" class="label text-sm">Ending Point</label>
                                    <input id="end" type="text" v-model="form.end" class="input input-sm input-bordered w-full" placeholder="e.g., Tulear" />
                                    <div v-if="form.errors.end" class="text-sm text-red-500 mt-1">{{ form.errors.end }}</div>
                                </div>
                                <div>
                                    <label for="duration" class="label text-sm">Duration (days)</label>
                                    <input id="duration" type="number" min="0" v-model="form.duration" class="input input-sm input-bordered w-full" placeholder="e.g., 14" />
                                    <div v-if="form.errors.duration" class="text-sm text-red-500 mt-1">{{ form.errors.duration }}</div>
                                </div>
                                <div>
                                    <label for="distance" class="label text-sm">Total Distance (km)</label>
                                    <input id="distance" type="number" min="0" v-model="form.distance" class="input input-sm input-bordered w-full" placeholder="e.g., 1200" />
                                    <div v-if="form.errors.distance" class="text-sm text-red-500 mt-1">{{ form.errors.distance }}</div>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <h3 class="font-semibold text-md mb-2">Pricing (in €)</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="price_3_pers" class="label text-sm">For 3 persons</label>
                                        <input id="price_3_pers" type="number" min="0" v-model="form.price_3_pers" class="input input-sm input-bordered w-full" placeholder="e.g., 1500" />
                                        <div v-if="form.errors.price_3_pers" class="text-sm text-red-500 mt-1">{{ form.errors.price_3_pers }}</div>
                                    </div>
                                    <div>
                                        <label for="price_6_pers" class="label text-sm">For 6 persons</label>
                                        <input id="price_6_pers" type="number" min="0" v-model="form.price_6_pers" class="input input-sm input-bordered w-full" placeholder="e.g., 1200" />
                                        <div v-if="form.errors.price_6_pers" class="text-sm text-red-500 mt-1">{{ form.errors.price_6_pers }}</div>
                                    </div>
                                    <div>
                                        <label for="price_max_pers" class="label text-sm">For 10+ persons</label>
                                        <input id="price_max_pers" type="number" min="0" v-model="form.price_max_pers" class="input input-sm input-bordered w-full" placeholder="e.g., 1000" />
                                        <div v-if="form.errors.price_max_pers" class="text-sm text-red-500 mt-1">{{ form.errors.price_max_pers }}</div>
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
                                        <XCircle size="16" />
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="label text-sm">Additional Images</label>
                                <div class="mt-1 flex justify-center px-4 py-3 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <UploadCloud class="mx-auto h-10 w-10 text-gray-400" />
                                        <div class="flex text-sm text-gray-600">
                                            <label for="images-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload files</span>
                                                <input id="images-upload" name="images-upload" type="file" multiple class="sr-only" @change="handleImagesChange">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                                <div v-if="form.errors.images" class="text-sm text-red-500 mt-1">{{ form.errors.images }}</div>
                                <div v-if="form.images.length" class="mt-3 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                                    <div v-for="(image, index) in form.images" :key="index" class="relative group">
                                        <img :src="getImageUrl(image)" :alt="image.name" class="w-full h-20 object-cover rounded-md shadow-md" />
                                        <button @click="removeImage(index)" type="button" class="absolute -top-2 -right-2 btn btn-xs btn-circle btn-error opacity-0 group-hover:opacity-100">
                                            <Trash2 size="14" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Options -->
                            <div class="form-control pt-4">
                                <label class="label cursor-pointer justify-start gap-4">
                                    <input type="checkbox" v-model="form.truck_disponibility" class="checkbox checkbox-primary" />
                                    <span class="label-text">4x4 Truck Available</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end items-center gap-4 pt-8">
                        <Link :href="route('circuits.index')" class="btn btn-ghost">Cancel</Link>
                        <button type="submit" class="btn btn-primary" :disabled="form.processing">
                            <Check class="size-4" /> Edit Itineraire
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
