<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm, Link } from '@inertiajs/vue3'

const form = useForm({
  title: '',
  duration: '',
  description: '',
  image: null,
})

const submit = () => {
  form.post(route('circuits.store'))
}
</script>

<template>
  <Head title="Créer un circuit" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-2xl font-bold text-gray-800">Créer un circuit</h2>
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
