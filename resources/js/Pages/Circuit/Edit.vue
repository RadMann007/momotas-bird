<script setup lang="ts">
import { CircuitInterface } from '@/interfaces/custom';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    circuit: CircuitInterface
}>();

const form = useForm({
  _method: 'put',
  title: props.circuit.title,
  duration: props.circuit.duration,
  description: props.circuit.description,
  image: null as File | null,
  start: props.circuit.start,
  end: props.circuit.end,
  distance: props.circuit.distance,
  truck_disponibility: props.circuit.truck_disponibility,
  price_3_pers: props.circuit.price_3_pers,
  price_6_pers: props.circuit.price_6_pers,
  price_max_pers: props.circuit.price_max_pers
})

const submit = () => {
    form.post(route('circuits.update', props.circuit.id));
}

</script>

<template>
    <Head title="Circuit"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold text-gray-800">Modifier un circuit</h2>
        </template>

        <div class="py-12">
      <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">
          <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-6">
            
            <!-- Title -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Titre</label>
              <input
                type="text"
                v-model="form.title"
                class="input input-bordered w-full mt-1"
                placeholder="Ex: On the Quest of Madagascar Endemic Birds"
              />
              <div v-if="form.errors.title" class="text-sm text-red-500 mt-1">
                {{ form.errors.title }}
              </div>
            </div>

            <!-- Duration -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Durée</label>
              <input
                type="text"
                v-model="form.duration"
                class="input input-bordered w-full mt-1"
                placeholder="21 nuits / 22 jours"
              />
              <div v-if="form.errors.duration" class="text-sm text-red-500 mt-1">
                {{ form.errors.duration }}
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">

                <div>
                <label class="block text-sm font-medium text-gray-700">Start</label>
                <input
                  type="text"
                  v-model="form.start"
                  class="input input-bordered w-full mt-1"
                  placeholder="Antsirabe"
                />
                <div v-if="form.errors.duration" class="text-sm text-red-500 mt-1">
                  {{ form.errors.start }}
                </div>
              </div>

                <!-- End -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">End</label>
                  <input
                    type="text"
                    v-model="form.end"
                    class="input input-bordered w-full mt-1"
                    placeholder="Betafo"
                  />
                  <div v-if="form.errors.end" class="text-sm text-red-500 mt-1">
                    {{ form.errors.duration }}
                  </div>
                </div>
             </div>

              <!-- Price 3 pers -->
              <div class="grid grid-cols-3 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Price for 3</label>
                  <input
                    type="text"
                    v-model="form.price_3_pers"
                    class="input input-bordered w-full mt-1"
                    placeholder="Antsirabe"
                  />
                  <div v-if="form.errors.price_3_pers" class="text-sm text-red-500 mt-1">
                    {{ form.errors.duration }}
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700">Price for 6</label>
                  <input
                    type="text"
                    v-model="form.price_6_pers"
                    class="input input-bordered w-full mt-1"
                    placeholder="Antsirabe"
                  />
                  <div v-if="form.errors.price_6_pers" class="text-sm text-red-500 mt-1">
                    {{ form.errors.duration }}
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700">Max price</label>
                  <input
                    type="text"
                    v-model="form.price_max_pers"
                    class="input input-bordered w-full mt-1"
                    placeholder="Antsirabe"
                  />
                  <div v-if="form.errors.price_max_pers" class="text-sm text-red-500 mt-1">
                    {{ form.errors.duration }}
                  </div>
                </div>
              </div>

            <!-- Description -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Description</label>
              <textarea
                v-model="form.description"
                rows="4"
                class="textarea textarea-bordered w-full mt-1"
                placeholder="Décrivez le circuit..."
              />
              <div v-if="form.errors.description" class="text-sm text-red-500 mt-1">
                {{ form.errors.description }}
              </div>
            </div>

            <!-- Image -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Image</label>
              <input
                type="file"
                @input="form.image = $event.target.files[0]"
                class="file-input file-input-bordered w-full mt-1"
              />
              <div v-if="form.errors.image" class="text-sm text-red-500 mt-1">
                {{ form.errors.image }}
              </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center">
              <Link
                :href="route('circuits.index')"
                class="btn btn-ghost"
              >
                Annuler
              </Link>
              <button
                type="submit"
                class="btn btn-primary"
                :disabled="form.processing"
              >
                Sauvegarder
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
        
    </AuthenticatedLayout>
</template>