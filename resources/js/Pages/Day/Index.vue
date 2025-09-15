<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';
import { Head, Link } from '@inertiajs/vue3';
import { PlusCircle } from 'lucide-vue-next';
import { ref, computed } from 'vue';

interface Circuit {
    id: number
    title: string
    duration: string
    description: string
}

interface EtapeCircuit {
    id: number
    title: string
    description: string
    circuit_id: number
    circuit: Circuit
    created_at: string
    image: string
    distance: number
    start: string
    end: string
    hotel_name: string
    hotel_description: string
}

const props = defineProps<{
    etapes: EtapeCircuit[],
    circuits: Circuit[]
}>();

const deleteStep = ({id}: {id: number}) => {
    if(confirm("Voulez-vous vraiment effacer ?")){
        router.delete(route('days.destroy', id));
    }
}
const selectedCircuit = ref(null);

const filteredStep = computed(()=> {
    if(selectedCircuit.value != null || selectedCircuit.value != undefined){
        return props.etapes.filter(e => e.circuit_id === selectedCircuit.value);
    }else{
        return props.etapes
    }
})

</script>

<template>
    <Head title="Days"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-8">Liste des étapes</h2>
            </div>
            <div>
                <div class="flex justify-between">
                    <select class="mb-4 select select-primary" v-model="selectedCircuit">
                        <option :value="null">All</option>
                        <option v-for="c in props.circuits" :key="c.id" :value="c.id">{{ c.title }}</option>
                    </select>
                    <Link class="btn btn-primary" :href="route('days.create')"><PlusCircle class="size-4"/> Add Step</Link>
                </div>

                <table class="table w-full bg-base-100 shadow">
                    <tr class="bg-gray-100">
                        <th>#</th>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Desc</th>
                        <th>Circuit</th>
                        <th class="">Actions</th>
                    </tr>
                    <tr v-for="step in filteredStep" :key="step.id" class="">
                        <td class="">{{ step.id }}</td>
                        <td class="">
                            <img class="w-14 object-cover" 
                            :src="`/storage/${step.image}`"
                            />
                        </td>
                        <td>{{ step.title }}</td>
                        <td class="max-w-xs truncate">{{ step.description }}</td>
                        <td>{{ step.circuit.title }}</td>
                        <td class="flex gap-2">
                            <Link class="btn btn-warning btn-xs" :href="route('days.edit', step.id)">Modifier</Link>
                            <button @click="deleteStep({id: step.id})" class="btn btn-error btn-xs text-white">Supprimer</button>
                        </td>
                        <!-- <td class="w-1/2 text-wrap">{{ step.description }}</td> -->
                    </tr>
                </table>

            </div>
        </template>
    </AuthenticatedLayout>
</template>