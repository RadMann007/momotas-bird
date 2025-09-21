<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import type { CircuitInterface } from '@/interfaces/custom';
import { Link } from '@inertiajs/vue3';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/autoplay';

import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';

const props = defineProps<{ 
  itineraires: CircuitInterface[],
  canLogin: Boolean,
  canRegister: Boolean,
}>();

const modules = [Navigation, Pagination, Autoplay];
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
    <div class="max-w-6xl mx-auto px-4">
      <swiper
        v-if="props.itineraires.length > 0"
        :modules="modules"
        :navigation="true"
        :pagination="{ clickable: true }"
        :slides-per-view="1"
        :space-between="0"
        :loop="true"
        :autoplay="{ delay: 5000, disableOnInteraction: false }"
        class="main-carousel"
      >
        <swiper-slide v-for="it in props.itineraires" :key="it.id">
          <div class="relative h-96 md:h-[500px] overflow-hidden rounded-2xl shadow-xl group">
            <img 
              :src="`/storage/${it.image}`" 
              :alt="it.title" 
              class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105" 
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-8">
              <div class="text-white max-w-xl translate-y-4 opacity-0 transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100">
                <h2 class="text-3xl md:text-4xl font-bold leading-tight">{{ it.title }}</h2>
                <p class="text-lg italic text-yellow-300 mt-2">{{ it.duration }}</p>
                <p class="mt-4 text-sm leading-relaxed">{{ it.description }}</p>
                <Link :href="`/itineraires/${it.id}`" class="mt-4 inline-flex items-center gap-2 text-white bg-emerald-600 hover:bg-emerald-700 font-bold py-2 px-5 rounded-full transition-colors">
                  Voir plus
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                  </svg>
                </Link>
              </div>
            </div>
          </div>
        </swiper-slide>
      </swiper>
      <div v-else class="flex items-center justify-center h-96 bg-gray-100 rounded-2xl shadow-lg">
        <p class="text-gray-500">Aucun itinéraire disponible</p>
      </div>
    </div>
    
    <section class="max-w-6xl mx-auto px-4 mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="it in props.itineraires" :key="it.id" class="card-container">
        <Link :href="`/itineraires/${it.id}`">
          <article class="bg-white rounded-xl shadow p-4 flex flex-col card-inner h-full">
            <div class="h-40 overflow-hidden rounded-lg mb-3">
              <img :src="`/storage/${it.image}`" :alt="it.title" class="w-full h-full object-cover" />
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
/* Styles de la navigation du carrousel pour un look plus moderne */
.main-carousel .swiper-button-prev,
.main-carousel .swiper-button-next {
  @apply text-white bg-black/40 hover:bg-black/60 transition-colors duration-300 w-10 h-10 rounded-full flex items-center justify-center;
  transform: translateY(-50%) scale(0.8);
  opacity: 0;
  transition: all 0.3s ease-in-out;
}

.main-carousel:hover .swiper-button-prev,
.main-carousel:hover .swiper-button-next {
  transform: translateY(-50%) scale(1);
  opacity: 1;
}

.main-carousel .swiper-button-prev {
  @apply left-4;
}

.main-carousel .swiper-button-next {
  @apply right-4;
}

.main-carousel .swiper-button-prev::after,
.main-carousel .swiper-button-next::after {
  @apply text-lg font-bold;
}

/* Styles pour les points de pagination */
.main-carousel .swiper-pagination-bullet {
  @apply bg-white/80 transition-colors duration-300;
}

.main-carousel .swiper-pagination-bullet-active {
  @apply bg-emerald-500;
}

/* Styles pour les cartes en dessous */
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