<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    circuit: {
        type: Object,
        required: true,
    },
});

</script>

<template>
    <Head :title="`Itinéraire - ${circuit.title}`" />
    <UserLayout>
        <!-- 1. Section Héroïque -->
        <div class="relative h-[85vh] w-full overflow-hidden">
            <!-- Image de fond avec effet Ken Burns -->
            <img :src="'/storage/'+props.circuit.image" alt="Image principale du circuit" class="absolute inset-0 h-full w-full object-cover ken-burns" />
            <!-- Dégradé pour la lisibilité -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

            <!-- Overlay avec les détails -->
            <div class="relative z-10 flex h-full flex-col items-start justify-end p-8 text-left text-white md:p-12 lg:p-16">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-6xl md:text-7xl drop-shadow-lg">
                    {{ circuit.title }}
                </h1>
                <p class="mt-4 max-w-2xl text-lg sm:text-xl drop-shadow-lg">
                    {{ circuit.description }}
                </p>
                <p class="mt-6 text-2xl font-bold text-primary drop-shadow-lg">{{ circuit.duration }}</p>
            </div>

             <!-- Indicateur de scroll -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2">
                <div class="mouse-scroll"></div>
            </div>
        </div>

        <!-- 2. Section du Programme -->
        <div class="bg-base-100 py-20">
            <div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12">Le programme jour par jour</h2>
                <div class="join join-vertical bg-base-100">
                    <div v-for="day in props.circuit.days" :key="day.id" class="collapse collapse-arrow join-item border-base-300 border">
                        <input type="radio" name="my-accordion-4" checked="checked" />
                        <div class="collapse-title font-semibold">{{ day.title }} / {{ day.distance }} Km</div>
                        <div class="collapse-content text-sm">
                            <div class="flex p-2 gap-2">
                                <img class="size-1/4 rounded-md object-cover"
                                :src="`/storage/${day.image}`"
                                />
                                <div>
                                    <p class="font-bold mb-1 underline">{{ day.start }} - {{ day.end }}</p>
                                    <p>
                                        {{ day.description }}
                                    </p>
                                </div>
                            </div>
                            <p class="mt-4 font-bold underline">{{ day.hotel_name }}</p>
                            <p>{{ day.hotel_description }}</p>
                            
                        </div>
                    </div>
                </div>

                <!-- Accordion des Jours -->
                <!-- <div class="space-y-2">
                    <div v-for="(day, index) in circuit.days" :key="day.id" class="collapse collapse-arrow bg-base-200 rounded-box">
                        <input type="radio" name="my-accordion-2" :checked="index === 0" />
                        <div class="collapse-title text-xl font-medium">
                            <div class="flex items-center">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary text-sm font-bold text-primary-content mr-4">{{ index + 1 }}</span>
                                {{ day.title }}
                            </div>
                        </div>
                        <div class="collapse-content">
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-2">
                                    <div class="prose max-w-none" v-html="day.description"></div>
                                </div>
                                <div v-if="day.image">
                                    <img :src="'/storage/'+day.image" alt="" class="rounded-lg shadow-lg">
                                </div>
                            </div>
                            <div v-if="day.hotel_name" class="mt-6 border-t pt-4">
                                <h4 class="text-lg font-semibold">Hébergement</h4>
                                <p class="text-md font-semibold text-gray-700">{{ day.hotel_name }}</p>
                                <div class="prose max-w-none text-sm" v-html="day.hotel_description"></div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </UserLayout>
</template>

<style scoped>
/* --- Effet Ken Burns pour l'image héroïque --- */
.ken-burns {
    animation: ken-burns-anim 20s ease-in-out infinite alternate;
}

@keyframes ken-burns-anim {
    from {
        transform: scale(1) translate(0, 0);
    }
    to {
        transform: scale(1.15) translate(2%, -2%);
    }
}

/* --- Indicateur de scroll animé --- */
.mouse-scroll {
    width: 24px;
    height: 40px;
    border: 2px solid white;
    border-radius: 12px;
    position: relative;
}
.mouse-scroll::before {
    content: '';
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 8px;
    background-color: white;
    border-radius: 2px;
    animation: scroll-down 2s infinite;
}

@keyframes scroll-down {
    0% { opacity: 1; transform: translate(-50%, 0); }
    50% { opacity: 1; transform: translate(-50%, 10px); }
    100% { opacity: 0; transform: translate(-50%, 10px); }
}

/* --- Style des cartes de jour --- */
.card-day {
    /* On peut ajouter des styles spécifiques ici si besoin */
}
</style>
