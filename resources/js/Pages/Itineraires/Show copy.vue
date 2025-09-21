<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    circuit: {
        type: Object,
        required: true,
    },
});

const activeDayId = ref(props.circuit.days.length > 0 ? props.circuit.days[0].id : null);
const activeIndex = ref(0);

const setActiveDay = (dayId) => {
    activeDayId.value = dayId;
    activeIndex.value = props.circuit.days.findIndex(d => d.id === dayId);
};

const nextDay = () => {
    const newIndex = (activeIndex.value + 1) % props.circuit.days.length;
    setActiveDay(props.circuit.days[newIndex].id);
};

const prevDay = () => {
    const newIndex = (activeIndex.value - 1 + props.circuit.days.length) % props.circuit.days.length;
    setActiveDay(props.circuit.days[newIndex].id);
};

const getCardStyle = (index) => {
    const offset = index - activeIndex.value;
    const translateX = offset * (window.innerWidth < 768 ? 260 : 380);
    const scale = activeIndex.value === index ? 1 : 0.85;
    const zIndex = 10 - Math.abs(offset);
    const opacity = Math.abs(offset) > 1 ? 0 : 1;

    return {
        transform: `translateX(${translateX}px) scale(${scale})`,
        zIndex: zIndex,
        opacity: opacity,
        transition: 'transform 0.5s ease, opacity 0.5s ease',
    };
};

if (props.circuit.days.length > 0) {
    setActiveDay(props.circuit.days[0].id);
}

const prices = ref([
    { label: 'base 3 pers.', value: props.circuit.price_3_pers },
    { label: 'base 6 pers.', value: props.circuit.price_6_pers },
    { label: 'base 10 pers.', value: props.circuit.price_max_pers }
]);
const activePriceIndex = ref(0);

let priceInterval;
let stepInterval;

onMounted(() => {
    priceInterval = setInterval(() => {
        activePriceIndex.value = (activePriceIndex.value + 1) % prices.value.length;
    }, 3000);
    stepInterval = setInterval(nextDay, 6000);
});

onUnmounted(() => {
    clearInterval(priceInterval);
    clearInterval(stepInterval);
});
</script>

<template>
    <Head :title="`Itinéraire - ${circuit.title}`" />
    <UserLayout>
        <!-- 1. Section Héroïque -->
        <div class="relative h-[85vh] w-full overflow-hidden">
            <img :src="'/storage/'+props.circuit.image" alt="Image principale du circuit" class="absolute inset-0 h-full w-full object-cover ken-burns" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
            <div class="relative z-10 flex h-full flex-col items-start justify-end p-8 text-left text-white md:p-12 lg:p-16">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-6xl md:text-7xl drop-shadow-lg">{{ circuit.title }}</h1>
                <p class="mt-4 max-w-3xl text-lg sm:text-xl drop-shadow-lg">{{ circuit.description }}</p>
                <p class="mt-6 text-2xl font-bold text-gray-500 drop-shadow-lg">{{ circuit.duration }}</p>
                <div class="mt-6 text-2xl font-bold text-gray-500 drop-shadow-lg">
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

        <!-- 2. Section du Programme -->
        <div class="bg-gray-50 py-24 sm:py-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 text-center mb-20">Daily Program</h2>
                
                <div class="grid grid-cols-1">
                    <!-- Carousel for Steps -->
                    <div class="col-span-1">
                        <div class="relative flex items-center justify-center h-[48rem]">
                            <button @click="prevDay" class="absolute top-1/2 -translate-y-1/2 left-4 sm:left-8 md:left-16 lg:left-24 z-20 bg-white text-gray-800 p-4 rounded-full shadow-lg hover:bg-gray-100 transition-transform duration-300 hover:scale-110">&#10094;</button>
                            <button @click="nextDay" class="absolute top-1/2 -translate-y-1/2 right-4 sm:right-8 md:right-16 lg:right-24 z-20 bg-white text-gray-800 p-4 rounded-full shadow-lg hover:bg-gray-100 transition-transform duration-300 hover:scale-110">&#10095;</button>
                            <div v-for="(day, index) in circuit.days" :key="day.id"
                                 class="absolute w-[90%] md:w-[32rem] lg:w-[40rem] transition-all duration-500 ease-in-out"
                                 :style="getCardStyle(index)"
                                 @click="setActiveDay(day.id)">
                                
                                <div v-if="activeIndex === index" class="bg-white rounded-2xl shadow-2xl overflow-hidden cursor-pointer w-[90%]">
                                    <div class="h-64">
                                        <img v-if="day.image" :src="'/storage/' + day.image" alt="Photo" class="w-full h-full object-cover">
                                        <div v-else class="w-full h-full bg-gray-200"></div>
                                    </div>
                                    <div class="p-8">
                                        <h3 class="text-3xl font-bold text-gray-900">Day {{ index + 1 }}</h3>
                                        <!-- <h3 class="text-3xl font-bold text-gray-900">Day {{ index + 1 }}: {{ day.title }}</h3> -->
                                        <div class="flex items-center mt-4 space-x-4 text-sm">
                                            <span class="font-medium bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full">{{ day.distance }} Km</span>
                                            <p class="font-semibold text-gray-700">{{ day.start }} → {{ day.end }}</p>
                                        </div>
                                        <div class="mt-6 text-gray-600 text-sm space-y-4">
                                            <p class="leading-relaxed">{{ day.description }}</p>
                                            <div v-if="day.hotel_name" class="border-t border-gray-200 pt-4 mt-4">
                                                <h4 class="text-base font-semibold text-gray-800">Accommodation</h4>
                                                <p class="mt-2 font-semibold text-gray-700">{{ day.hotel_name }}</p>
                                                <p v-if="day.hotel_description" class="mt-1 italic text-gray-500">{{ day.hotel_description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-else class="bg-white rounded-2xl blur-sm shadow-xl p-2 flex flex-col items-center justify-center text-center cursor-pointer h-80 hover:shadow-2xl transition-shadow">
                                    <span class="font-bold text-5xl text-emerald-500">{{ index + 1 }}</span>
                                    <p class="font-semibold text-2xl mt-4 text-gray-800">{{ day.title }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<style scoped>
.ken-burns { animation: ken-burns-anim 20s ease-in-out infinite alternate; }
@keyframes ken-burns-anim { from { transform: scale(1) translate(0, 0); } to { transform: scale(1.15) translate(2%, -2%); } }
.mouse-scroll { width: 24px; height: 40px; border: 2px solid white; border-radius: 12px; position: relative; }
.mouse-scroll::before { content: ''; position: absolute; top: 8px; left: 50%; transform: translateX(-50%); width: 4px; height: 8px; background-color: white; border-radius: 2px; animation: scroll-down 2s infinite; }
@keyframes scroll-down { 0% { opacity: 1; transform: translate(-50%, 0); } 50% { opacity: 1; transform: translate(-50%, 10px); } 100% { opacity: 0; transform: translate(-50%, 10px); } }
.slide-fade-enter-active, .slide-fade-leave-active { transition: all 0.5s ease-out; }
.slide-fade-enter-from { opacity: 0; transform: translateY(20px); }
.slide-fade-leave-to { opacity: 0; transform: translateY(-20px); }
</style>
