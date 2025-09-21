<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    type: '',
    description: '',
    image: null,
    images: []
});

const submit = () => {
    form.post(route('birds.store'), {
        forceFormData: true 
    });
    form.reset();
}
</script>

<template>
    <Head title="Birds"/>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="bg-white shadow rounded-lg p-6">
                    <h1>Bird</h1>
                    <form @submit.prevent="submit" class="flex flex-col gap-2">
                        <input v-model="form.name" type="text" class="input-field"/>
                        <input v-model="form.type" type="text" class="input-field" placeholder="type"/>
                        <textarea v-model="form.description"></textarea>
                        
                        <div class="bg-red-500 p-2 flex flex-col gap-4">
                            <label>Main Image</label>
                            <input 
                            @input="form.image = $event.target.files[0]"
                            type="file" 
                            class="file-input file-input-bordered w-full"/>
                        </div>

                        <div class="bg-gray-200 p-2 flex flex-col gap-4">
                            <label>All Images</label>
                            <input multiple
                            @input="form.images = Array.from($event.target.files)"
                            type="file" 
                            class="file-input file-input-bordered w-full"/>
                        </div>
                        
                        <button :disabled="form.processing" class="btn btn-primary">valider</button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>