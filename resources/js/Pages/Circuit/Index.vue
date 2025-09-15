<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { PlusCircle } from 'lucide-vue-next'
import { ref } from 'vue';


defineProps({
  circuits: Array
})

const destroy = (id) => {
  if (confirm('Voulez-vous vraiment supprimer ce circuit ?')) {
    router.delete(route('circuits.destroy', id))
  }
}

const imagePreview = ({img}) => {
  imgPath.value = img;
  modalOpen.value = true;
}

const modalOpen = ref(false);
const imgPath = ref('');
</script>

<template>
  <Head title="Liste des circuits" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Liste des circuits</h2>
        <Link :href="route('circuits.create')" class="btn btn-primary">
          <PlusCircle /> Nouveau circuit
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div
          v-if="circuits.length"
          class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
        >
          <!-- Cards -->
          <div
            v-for="circuit in circuits"
            :key="circuit.id"
            class="card bg-white shadow-md hover:shadow-xl transition duration-300 border border-gray-100"
          >
            <figure>
              <img @click="imagePreview({img: '/storage/'+circuit.image})"
                v-if="circuit.image"
                :src="`/storage/${circuit.image}`"
                alt="Circuit image"
                class="h-48 w-full object-cover"
              />
              <div
                v-else
                class="h-48 w-full flex items-center justify-center bg-gray-200 text-gray-500"
              >
                Pas d'image
              </div>
            </figure>
            <div class="card-body">
              <h3 class="card-title">{{ circuit.title }}</h3>
              <p class="text-gray-500">{{ circuit.duration }}</p>
              <p class="line-clamp-3 text-sm text-gray-600">
                {{ circuit.description }}
              </p>

              <div class="card-actions justify-end mt-4">
                <Link
                  :href="route('circuits.show', circuit.id)"
                  class="btn btn-sm btn-outline"
                >
                  Voir
                </Link>
                <Link
                  :href="route('circuits.edit', circuit.id)"
                  class="btn btn-sm btn-secondary"
                >
                  Éditer
                </Link>
                <button
                  @click="destroy(circuit.id)"
                  class="btn btn-sm btn-error text-white"
                >
                  Supprimer
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty state -->
        <div v-else class="text-center py-12 text-gray-500">
          Aucun circuit trouvé.
        </div>
      </div>
    </div>

    <dialog v-if="modalOpen" class="w-screen modal modal-open">
      <button type="button" class="btn" @click="modalOpen = false">X</button>
      <div class="modal-box max-w-5xl">
        <img :src="imgPath" class="w-full" />
      </div>
    </dialog>
  </AuthenticatedLayout>
</template>
