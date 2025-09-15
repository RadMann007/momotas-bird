<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import type { CircuitInterface } from '@/interfaces/custom'
import { Link } from '@inertiajs/vue3'

const props = defineProps<{ 
    itineraires: CircuitInterface[],
    canLogin: Boolean,
    canRegister: Boolean,
 }>()

const length = computed(() => props.itineraires?.length ?? 0)
const currentIndex = ref<number>(0)

const prev = () => {
  if (length.value === 0) return
  currentIndex.value = (currentIndex.value - 1 + length.value) % length.value
}
const next = () => {
  if (length.value === 0) return
  currentIndex.value = (currentIndex.value + 1) % length.value
}

// Autoplay (5s) - retire si tu veux pas
let timer: ReturnType<typeof setInterval> | null = null
onMounted(() => {
  if (length.value > 1) {
    timer = setInterval(() => {
      currentIndex.value = (currentIndex.value + 1) % length.value
    }, 5000)
  }
})
onBeforeUnmount(() => { if (timer) clearInterval(timer) })
</script>

<template>
    <header class="fixed top-0 w-full bg-white/80 backdrop-blur-lg shadow-sm z-50">
            <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
                <Link href="/" class="text-2xl font-bold text-emerald-600 tracking-tight flex items-center gap-2">
                    <span class="text-3xl">🦜</span>
                    <span>Momotas Bird</span>
                </Link>
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <Link :href="route('itineraires.index')" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Tours</Link>
                    <a href="/#galerie" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Gallery</a>
                    <a href="/#contact" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Contact</a>
                </nav>
                <div class="hidden md:flex items-center gap-4">
                    <template v-if="!$page.props.auth.user">
                        <Link v-if="canLogin" :href="route('login')" class="text-sm font-medium text-gray-600 hover:text-emerald-600">Log in</Link>
                        <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm font-bold bg-emerald-500 text-white px-4 py-2 rounded-full hover:bg-emerald-600 transition-transform transform hover:scale-105">
                            Register
                        </Link>
                    </template>
                     <Link v-else :href="route('dashboard')" class="text-sm font-medium text-emerald-600 hover:underline">
                        Dashboard
                    </Link>
                </div>
            </div>
        </header>
  <div class="bg-gray-50 min-h-screen pb-12 pt-24">
    <!-- Header -->
    <!-- <header class="text-center py-8">
      <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800">Nos Itinéraires</h1>
      <p class="text-gray-600 mt-2">Découvrez des voyages uniques à Madagascar</p>
    </header> -->

    <!-- Carousel -->
    <div class="max-w-6xl mx-auto px-4">
      <div class="relative">
        <div class="relative h-64 md:h-96 overflow-hidden rounded-2xl shadow-lg">
          <template v-if="length">
            <div
              v-for="(it, index) in props.itineraires"
              :key="it.id"
              class="absolute inset-0 w-full h-full transition-transform duration-700 ease-in-out"
              :style="{ transform: `translateX(${(index - currentIndex) * 100}%)` }"
            >
            <img :src="`/storage/${it.image}`" :alt="it.title" class="w-full h-full object-cover" />

              <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-5 md:p-8">
                <div class="text-white max-w-xl">
                  <h2 class="text-lg md:text-2xl font-bold">{{ it.title }}</h2>
                  <p class="text-sm italic text-yellow-300 mt-1">{{ it.duration }}</p>
                  <p class="hidden md:block mt-2 text-sm leading-relaxed">{{ it.description }}</p>
                </div>
              </div>
            </div>
          </template>
          <div v-else class="flex items-center justify-center h-full bg-gray-100">
            <p class="text-gray-500">Aucun itinéraire disponible</p>
          </div>
        </div>

        <!-- Controls -->
        <button
          v-if="length > 1"
          @click="prev"
          class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow-md"
        >‹</button>
        <button
          v-if="length > 1"
          @click="next"
          class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow-md"
        >›</button>
      </div>

      <!-- Dots -->
      <div class="flex justify-center mt-4 space-x-2">
        <button
          v-for="(it, i) in props.itineraires"
          :key="i"
          @click="currentIndex = i"
          :class="['h-3 w-3 rounded-full transition-transform', i === currentIndex ? 'bg-gray-800 scale-125' : 'bg-gray-300']"
        />
      </div>
    </div>

    <!-- Cards en dessous -->
    <section class="max-w-6xl mx-auto px-4 mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="it in props.itineraires" :key="it.id" class="card-container">
        <Link :href="`/itineraires/${it.id}`">
          <article class="bg-white rounded-xl shadow p-4 flex flex-col card-inner h-full">
            <div class="h-40 overflow-hidden rounded-lg mb-3">
              <img :src="`/storage/${it.image}`" alt="" class="w-full h-full object-cover" />
            </div>
            <h3 class="font-semibold text-lg">{{ it.title }}</h3>
            <p class="text-sm italic text-yellow-500 mt-1">{{ it.duration }}</p>
            <p class="text-sm text-gray-600 mt-2 line-clamp-1">{{ it.description }}</p>
          </article>
        </Link>
      </div>
    </section>
  </div>
</template>

<style>
.card-container {
    perspective: 1000px;
}
.card-inner {
    transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    transform-style: preserve-3d;
}
.card-container:hover .card-inner {
    transform: translateY(-10px) rotateY(15deg);
    box-shadow: 0 25px 50px -12px rgba(34, 197, 94, 0.25);
}
</style>