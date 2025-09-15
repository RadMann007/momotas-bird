<script setup lang="ts">
import { CircuitWithDay } from '@/interfaces/custom';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps<{
  circuit: CircuitWithDay
}>();

/* --- Form pour ajouter une Etape --- */
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
  if (confirm('Confirmer la suppression de cette étape ?')){
    router.delete(route('days.destroy', id));
  }
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
      <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col md:flex-row">
        <div class="w-1/3 h-36">
          <img 
              v-if="props.circuit.image"
              :src="`/storage/${props.circuit.image}`" 
              alt="Image Circuit" 
              class="object-cover"
            />
        </div>

        <div class="p-4 flex-1 flex flex-col justify-between">
          <div>
            <h2 class="text-2xl font-bold mb-1">{{ props.circuit.title }}</h2>
            <p class="text-gray-600 text-sm mb-2">
              <span class="font-semibold">Durée :</span> {{ props.circuit.duration }} jours
            </p>
            <p class="text-gray-600 text-sm mb-2">
              <span class="font-semibold">De:</span> {{ props.circuit.start }} <span class="font-semibold">à:</span> {{ props.circuit.end }}
            </p>
            <p class="text-gray-700 text-sm mb-3">{{ props.circuit.description }}</p>
          </div>

          <div class="bg-gray-50 p-3 rounded-lg">
            <h3 class="text-lg font-semibold mb-2 text-gray-800">Tarifs</h3>
            <div class="flex justify-around text-center">
              <div class="px-2">
                <p class="text-xs text-gray-600">3 personnes</p>
                <p class="text-lg font-bold text-primary">{{ props.circuit.price_3_pers }} €</p>
              </div>
              <div class="px-2">
                <p class="text-xs text-gray-600">6 personnes</p>
                <p class="text-lg font-bold text-primary">{{ props.circuit.price_6_pers }} €</p>
              </div>
              <div class="px-2">
                <p class="text-xs text-gray-600">Max personnes</p>
                <p class="text-lg font-bold text-primary">{{ props.circuit.price_max_pers }} €</p>
              </div>
            </div>
          </div>
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
        <!-- <button class="btn btn-primary" @click="modalOpen = true">
          + Ajouter Etape
        </button> -->
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
              <td colspan="5" class="text-center py-6 text-gray-500">Aucun Etape pour ce circuit.</td>
            </tr>

            <tr v-for="(day, idx) in paginated" :key="day.id">
              <td>{{ (currentPage - 1) * perPage + (idx + 1) }}</td>
              <td class="font-medium">{{ day.title }}</td>
              <td class="hidden md:table-cell">
                <div class="max-w-xs truncate" :title="day.description">{{ day.description }}</div>
              </td>
              <td>{{ formatDate(day.created_at) }}</td>
              <td class="text-center">
                <Link class="btn btn-ghost btn-sm" :href="route('days.edit', day.id)">
                  Modifier
                </Link>
                <button class="btn btn-error btn-sm ml-2 text-white" @click="deleteDay(day.id)">
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
          <textarea v-model="form.description" placeholder="Description" class="textarea textarea-bordered w-full" rows="5"></textarea>
          <div class="modal-action">
            <button type="button" class="btn" @click="modalOpen = false">Annuler</button>
            <button type="submit" class="btn btn-primary" :disabled="form.processing">Ajouter</button>
          </div>
        </form>
      </div>
    </dialog>
  </AuthenticatedLayout>
</template>
