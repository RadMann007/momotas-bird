<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    birds: Array
})
</script>

<template>
    <AuthenticatedLayout>
        <div class="bg-white">
            <ul class="p-6 mx-40">
                <li v-for="b in props.birds" :key="b.id">
                    <div class="border mt-4 p-6">
                        <div class="relative">
                            <img :src="'storage/'+b.image" class="w-1/4 object-cover"/>

                            <div class="absolute inset-0 flex items-start justify-start">
                                <p class="bg-orange-300 p-2">{{ b.name }} - type: {{ b.type }}</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-4">
                            <span v-for="im in b.images" :key="im.id">
                                <img :src="'storage/'+im.path" class="w-14 object-cover"/>
                            </span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <!-- {{ props.birds }} -->
    </AuthenticatedLayout>
</template>