<script setup lang="ts">
import { CircuitWithDay } from '@/interfaces/custom';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps<{
  circuit: CircuitWithDay
}>();

/* --- Form pour ajouter un Day --- */
const form = useForm({
  title: '',
  description: '',
  circuit_id: props.circuit.id
});

function submit() {
  form.post(route('days.store'), {
    onSuccess: () => {
      form.reset();
      modalOpen.value = false;
    }
  });
}

/* --- Suppression --- */
// const delForm = router
function deleteDay(id: number) {
  if (!confirm('Confirmer la suppression de ce Day ?')) return;
  router.delete(route('days.destroy', id));
}

/* --- Table + recherche + pagination client-side --- */
const search = ref('');
const perPage = ref(10);
const currentPage = ref(1);

const days = computed(() => props.circuit.days ?? []);

const filtered = computed(() => {
  const q = search.value.trim().toLowerCase();
  if (!q) return days.value;
  return days.value.filter(d =>
    (`${d.title ?? ''} ${d.description ?? ''}`).toLowerCase().includes(q)
  );
});

const totalPages = computed(() => Math.max(1, Math.ceil(filtered.value.length / perPage.value)));

const paginated = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  return filtered.value.slice(start, start + perPage.value);
});

function goToPage(n: number) {
  if (n < 1) n = 1;
  if (n > totalPages.value) n = totalPages.value;
  currentPage.value = n;
}

function formatDate(dt: string | null) {
  if (!dt) return '';
  return new Date(dt).toLocaleDateString('fr-FR', { year: 'numeric', month: 'short', day: 'numeric' });
}

/* --- Modal --- */
const modalOpen = ref(false);
</script>

<template>
  <Head :title="`Circuit - ${props.circuit.title}`" />
  <AuthenticatedLayout>
    <div class="max-w-6xl mx-auto p-6 space-y-6">
      <!-- Card Circuit -->
      <!-- <div class="card bg-base-100 shadow">
        <figure v-if="props.circuit.image">
          <img :src="`/storage/${props.circuit.image}`" alt="Image Circuit" class="w-full h-64 object-cover" />
        </figure>
        <div class="card-body">
          <h2 class="card-title text-2xl">{{ props.circuit.title }}</h2>
          <p class="text-gray-600"><strong>Durée :</strong> {{ props.circuit.duration }}</p>
          <p class="mt-2">{{ props.circuit.description }}</p>
        </div>
      </div> -->
      <div class="card card-compact w-full bg-base-100 shadow-xl flex flex-row items-center p-4 space-x-4">
  <!-- Avatar image -->
  <div class="avatar">
    <div class="w-32 rounded-xl ring ring-primary ring-offset-base-100 ring-offset-2 overflow-hidden">
      <img 
        v-if="props.circuit.image"
        :src="`/storage/${props.circuit.image}`" 
        alt="Image Circuit" 
        class="object-cover w-full h-full"
      />
    </div>
  </div>

      <!-- Contenu de la card -->
      <div class="flex-1 space-y-2">
        <h2 class="card-title text-2xl">{{ props.circuit.title }}</h2>
        <p class="text-gray-500 font-semibold">Durée : {{ props.circuit.duration }}</p>
        <p class="text-gray-700">{{ props.circuit.description }}</p>

        <!-- <div class="card-actions pt-2">
          <button class="btn btn-primary">Réserver</button>
          <button class="btn btn-outline">Partager</button>
        </div> -->
      </div>
      </div>

      

      <!-- Table controls -->
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-2">
          <input v-model="search" type="text" placeholder="Rechercher un Day..." class="input input-bordered" />
          <select v-model.number="perPage" class="select select-bordered">
            <option :value="5">5 / page</option>
            <option :value="10">10 / page</option>
            <option :value="20">20 / page</option>
            <option :value="50">50 / page</option>
          </select>
        </div>

        <!-- bouton ouvrir modale -->
        <button class="btn btn-primary" @click="modalOpen = true">
          + Ajouter un Day
        </button>
      </div>

      <!-- Table des Days -->
      <div class="overflow-x-auto bg-white rounded shadow">
        <table class="table w-full">
          <thead>
            <tr>
              <th>#</th>
              <th>Titre</th>
              <th class="hidden md:table-cell">Description</th>
              <th>Date</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="paginated.length === 0">
              <td colspan="5" class="text-center py-6 text-gray-500">Aucun Day pour ce circuit.</td>
            </tr>

            <tr v-for="(day, idx) in paginated" :key="day.id">
              <td>{{ (currentPage - 1) * perPage + (idx + 1) }}</td>
              <td class="font-medium">{{ day.title }}</td>
              <td class="hidden md:table-cell">
                <div class="max-w-xs truncate" :title="day.description">{{ day.description }}</div>
              </td>
              <td>{{ formatDate(day.created_at) }}</td>
              <td class="text-center">
                <button class="btn btn-ghost btn-sm" @click="$inertia.visit(route('days.edit', day.id))">
                  Éditer
                </button>
                <button class="btn btn-error btn-sm ml-2" @click="deleteDay(day.id)">
                  Supprimer
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="flex items-center justify-between">
        <div class="btn-group">
          <button class="btn" :disabled="currentPage <= 1" @click="goToPage(currentPage - 1)">Précédent</button>
          <button v-for="p in totalPages" :key="p" class="btn" :class="{'btn-active': p === currentPage}" @click="goToPage(p)">{{ p }}</button>
          <button class="btn" :disabled="currentPage >= totalPages" @click="goToPage(currentPage + 1)">Suivant</button>
        </div>
        <div class="text-sm text-gray-600">
          Affiche {{ paginated.length }} / {{ filtered.length }} items
        </div>
      </div>
    </div>

    <!-- Modal Ajouter Day -->
    <dialog v-if="modalOpen" class="modal modal-open">
      <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Ajouter un Day</h3>
        <form @submit.prevent="submit" class="space-y-3">
          <input type="text" v-model="form.title" placeholder="Titre du Day" class="input input-bordered w-full" required />
          <textarea v-model="form.description" placeholder="Description" class="textarea textarea-bordered w-full"></textarea>
          <div class="modal-action">
            <button type="button" class="btn" @click="modalOpen = false">Annuler</button>
            <button type="submit" class="btn btn-primary" :disabled="form.processing">Ajouter</button>
          </div>
        </form>
      </div>
    </dialog>
  </AuthenticatedLayout>
</template>
