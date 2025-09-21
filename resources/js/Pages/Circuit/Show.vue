<script setup>
import { ref, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { XCircle } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';
// import { CircuitWithDayAndImages } from '@/interfaces/custom';

const props = defineProps({
  circuit: Array
});

const page = usePage();

watch(
  () => page.props.flash,
  (flash) => {
    if(flash.success){
      alert(flash.success)
    }
  }
)

const activeTab = ref('itinéraire');

const deleteImage = (id) => {
  if(confirm("Are you sure ?")){
    router.delete(route('image.destroy', id))
  }
}

</script>

<template>
  <Head :title="`Circuit - ${props.circuit.title}`" />
  <AuthenticatedLayout>
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6">

      <h1 class="text-4xl font-bold text-gray-800">{{ props.circuit.title }}</h1>

      <!-- Tab Navigation -->
      <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-6" aria-label="Tabs">
          <button @click="activeTab = 'itinéraire'" 
                  :class="['whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm',
                           activeTab === 'itinéraire' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300']">
            Itinéraire
          </button>
          <button @click="activeTab = 'galerie'" 
                  :class="['whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm',
                           activeTab === 'galerie' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300']">
            Galerie
          </button>
        </nav>
      </div>

      <!-- Tab Content -->
      <div>
        <!-- Itinerary Tab -->
        <div v-if="activeTab === 'itinéraire'" class="space-y-8">
          <!-- Circuit Main Info Card -->
          <div class="bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col md:flex-row">
            <div class="w-full md:w-1/3">
              <img v-if="props.circuit.image" :src="`/storage/${props.circuit.image}`" :alt="`Image for ${props.circuit.title}`" class="w-full h-full object-cover" />
              <div v-else class="w-full h-full bg-gray-200 flex items-center justify-center">
                <span class="text-gray-500">No primary image</span>
              </div>
            </div>
            <div class="p-6 flex-1 flex flex-col justify-between">
              <div>
                <div class="flex items-center text-gray-500 text-sm mb-4 space-x-4">
                  <span><i class="fa-regular fa-clock mr-1"></i> {{ props.circuit.duration }} jours</span>
                  <span><i class="fa-solid fa-road mr-1"></i> {{ props.circuit.distance }} km</span>
                  <span><i class="fa-solid fa-truck-plane mr-1"></i> {{ props.circuit.truck_disponibility }}</span>
                </div>
                <p class="text-gray-600 mb-4">{{ props.circuit.description }}</p>
                <div class="text-sm text-gray-600">
                  <p><span class="font-semibold">Départ:</span> {{ props.circuit.start }}</p>
                  <p><span class="font-semibold">Arrivée:</span> {{ props.circuit.end }}</p>
                </div>
              </div>
              <div class="bg-blue-50 p-4 rounded-lg mt-4">
                <h3 class="text-lg font-semibold mb-2 text-blue-900">Tarifs par personne</h3>
                <div class="flex justify-around text-center">
                  <div class="px-2"><p class="text-xs text-gray-600">Base 3 pers.</p><p class="text-xl font-bold text-blue-700">{{ props.circuit.price_3_pers }} €</p></div>
                  <div class="px-2"><p class="text-xs text-gray-600">Base 6 pers.</p><p class="text-xl font-bold text-blue-700">{{ props.circuit.price_6_pers }} €</p></div>
                  <div class="px-2"><p class="text-xs text-gray-600">Base max pers.</p><p class="text-xl font-bold text-blue-700">{{ props.circuit.price_max_pers }} €</p></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Steps (Days) Section -->
          <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-800 border-b pb-2">Étapes du Circuit</h2>
            <div v-if="!circuit.days || circuit.days.length === 0" class="text-center py-12 text-gray-500 bg-white rounded-xl shadow-md">
              <p>Aucune étape n'a été ajoutée pour ce circuit.</p>
            </div>
            <div v-else class="space-y-4">
              <div v-for="(day, index) in circuit.days" :key="day.id" class="bg-white rounded-xl shadow-sm p-5 transition hover:shadow-md">
                <h3 class="text-xl font-semibold text-gray-800">Jour {{ index + 1 }}: {{ day.title }}</h3>
                <p class="text-gray-600 mt-2">{{ day.description }}</p>
                <div class="border-t mt-4 pt-3 text-sm text-gray-500 space-y-1">
                    <p><span class="font-semibold">De:</span> {{ day.start }} <span class="font-semibold">à:</span> {{ day.end }}</p>
                    <p><span class="font-semibold">Distance:</span> {{ day.distance }} km</p>
                    <p v-if="day.hotel_name"><span class="font-semibold">Hôtel:</span> {{ day.hotel_name }} - {{ day.hotel_description }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Gallery Tab -->
        <div v-if="activeTab === 'galerie'">
          <div v-if="circuit.images && circuit.images.length > 0" class="bg-white rounded-xl shadow-md p-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
              <div v-for="image in circuit.images" :key="image.id" class="relative aspect-square bg-gray-100">
                <img :src="`/storage/${image.path}`" :alt="`Galerie image for ${circuit.title}`" 
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
                <button 
                  @click="deleteImage(image.id)"
                  type="button" 
                  class="absolute -top-2 -right-3 btn btn-xs btn-circle btn-error">
                    <XCircle size="16" />
                </button>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-20 text-gray-500 bg-white rounded-xl shadow-md">
            <p>Aucune image dans la galerie pour ce circuit.</p>
          </div>
        </div>
      </div>

    </div>
  </AuthenticatedLayout>
</template>