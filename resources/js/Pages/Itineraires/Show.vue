<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/autoplay';

import { Navigation, Pagination, Autoplay, EffectCoverflow } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';

const props = defineProps({
    circuit: {
        type: Object,
        required: true,
    },
});

const prices = ref([
    { label: 'base 3 pers.', value: props.circuit.price_3_pers },
    { label: 'base 6 pers.', value: props.circuit.price_6_pers },
    { label: 'base 10 pers.', value: props.circuit.price_max_pers }
]);

const activePriceIndex = ref(0);
let priceInterval;

onMounted(() => {
    priceInterval = setInterval(() => {
        activePriceIndex.value = (activePriceIndex.value + 1) % prices.value.length;
    }, 3000);
});

onUnmounted(() => {
    clearInterval(priceInterval);
});

const modules = [Navigation, Pagination, Autoplay, EffectCoverflow];
const modules2 = [Autoplay];
</script>

<template>
    <Head :title="`Itinéraire - ${props.circuit.title}`" />
    <UserLayout no-padding>
        <div class="relative w-full h-[75vh] bg-gray-800">
           <swiper
                :slidesPerView="1"
                :centeredSlides="true"
                :spaceBetween="30"
                :keyboard="{
                enabled: true,
                }"
                :loop="false" :autoplay="{ delay: 2500, disableOnInteraction: false }"
                :modules="modules2"
                class="mySwiper w-full h-full"
            >
                <swiper-slide v-for="im in props.circuit.images" :key="im.id">
                    <div class="w-full h-full">
                        <img v-if="im.path" :src="'/storage/' + im.path" :alt="im.id" class="w-full h-full object-cover">
                    </div>
                </swiper-slide>
            </swiper>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
            <div class="absolute inset-0 z-10 flex flex-col items-start justify-end p-8 text-left text-white md:p-12 lg:p-16">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-6xl md:text-7xl drop-shadow-lg">{{ circuit.title }}</h1>
                <p class="mt-4 max-w-3xl text-lg sm:text-xl drop-shadow-lg">{{ circuit.description }}</p>
                <p class="mt-6 text-2xl font-bold text-gray-200 drop-shadow-lg">{{ circuit.duration }}</p>
                <div class="mt-6 text-2xl font-bold text-gray-200 drop-shadow-lg">
                    <div class="relative h-20 w-80 text-left">
                        <transition name="slide-fade" mode="out-in">
                            <div :key="activePriceIndex" class="absolute w-full">
                                <p>À partir de {{ prices[activePriceIndex].value }} €</p>
                                <p class="text-sm">/ personne ({{ prices[activePriceIndex].label }})</p>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2">
                <div class="mouse-scroll"></div>
            </div>
        </div>

        <div class="bg-gray-50 py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 text-center mb-20">Daily Program</h2>
                
                <div class="daily-program-carousel relative">
                    <swiper
                        :modules="modules"
                        effect="coverflow"
                        :centeredSlides="true"
                        :slides-per-view="1.2"
                        :space-between="20"
                        :loop="false" :autoplay="{ delay: 2500, disableOnInteraction: false }"
                        :coverflowEffect="{
                        rotate: 50,
                        stretch: 0,
                        depth: 100,
                        modifier: 1,
                        slideShadows: true,
                        }"
                        :breakpoints="{
                            768: {
                                slidesPerView: 2.2,
                                spaceBetween: 40,
                            },
                            1024: {
                                slidesPerView: 2.5,
                                spaceBetween: 60,
                            },
                        }"
                        :pagination="{ clickable: true }"
                        :navigation="true"
                    >
                        <swiper-slide v-for="(day, index) in circuit.days" :key="day.id">
                            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden cursor-pointer h-full">
                                <div class="h-64">
                                    <img v-if="day.image" :src="'/storage/' + day.image" :alt="day.title" class="w-full h-full object-cover">
                                    <div v-else class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">Pas d'image</span>
                                    </div>
                                </div>
                                <div class="p-8">
                                    <h3 class="text-3xl font-bold text-gray-900">Day {{ index + 1 }}</h3>
                                    <div class="flex items-center mt-4 space-x-4 text-sm">
                                        <span class="font-medium bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full">{{ day.distance }} Km</span>
                                        <p class="font-semibold text-gray-700">{{ day.start }} → {{ day.end }}</p>
                                    </div>
                                    <div class="mt-6 text-gray-600 text-sm space-y-4">
                                        <p class="leading-relaxed line-clamp-3">{{ day.description }}</p>
                                        <div v-if="day.hotel_name" class="border-t border-gray-200 pt-4 mt-4">
                                            <h4 class="text-base font-semibold text-gray-800">Accommodation</h4>
                                            <p class="mt-2 font-semibold text-gray-700">{{ day.hotel_name }}</p>
                                            <p v-if="day.hotel_description" class="mt-1 italic text-gray-500 line-clamp-1">{{ day.hotel_description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<style scoped>
/* Suppression des styles du carrousel manuel */
.ken-burns { animation: ken-burns-anim 20s ease-in-out infinite alternate; }
@keyframes ken-burns-anim { from { transform: scale(1) translate(0, 0); } to { transform: scale(1.15) translate(2%, -2%); } }
.mouse-scroll { width: 24px; height: 40px; border: 2px solid white; border-radius: 12px; position: relative; }
.mouse-scroll::before { content: ''; position: absolute; top: 8px; left: 50%; transform: translateX(-50%); width: 4px; height: 8px; background-color: white; border-radius: 2px; animation: scroll-down 2s infinite; }
@keyframes scroll-down { 0% { opacity: 1; transform: translate(-50%, 0); } 50% { opacity: 1; transform: translate(-50%, 10px); } 100% { opacity: 0; transform: translate(-50%, 10px); } }
.slide-fade-enter-active, .slide-fade-leave-active { transition: all 0.5s ease-out; }
.slide-fade-enter-from { opacity: 0; transform: translateY(20px); }
.slide-fade-leave-to { opacity: 0; transform: translateY(-20px); }

/* Styles pour le carrousel Swiper.js */
.daily-program-carousel {
    height: 38rem; /* Hauteur fixe pour le conteneur du carrousel */
}

/* Styles pour les flèches de navigation */
.daily-program-carousel .swiper-button-prev,
.daily-program-carousel .swiper-button-next {
    @apply text-white bg-black/40 hover:bg-black/60 transition-colors duration-300 w-12 h-12 rounded-full flex items-center justify-center top-[30%] -translate-y-1/2;
}

.daily-program-carousel .swiper-button-prev {
    @apply left-4;
}

.daily-program-carousel .swiper-button-next {
    @apply right-4;
}

.daily-program-carousel .swiper-button-prev::after,
.daily-program-carousel .swiper-button-next::after {
    @apply text-lg font-bold;
}

/* Styles pour les points de pagination */
.daily-program-carousel .swiper-pagination {
    @apply bottom-4;
}

.daily-program-carousel .swiper-pagination-bullet {
    @apply bg-gray-400 transition-colors duration-300;
}

.daily-program-carousel .swiper-pagination-bullet-active {
    @apply bg-emerald-500;
}
</style>