<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    circuits: {
      type: Array,
      required: true
    }
});

const form = useForm({
    name: '',
    email: '',
    message: ''
});

const submit = () => {
    form.post(route('contact.store'), {
        onFinish: () => form.reset('name', 'email', 'message'),
    });
};

const galleryImages = [
    { id: 1, src: '/images/2.jpg', alt: 'Van Dam\'s Vanga', name: 'Van Dam\'s Vanga' },
    { id: 2, src: '/images/3.jpg', alt: 'Blue Coua', name: 'Blue Coua' },
    { id: 3, src: '/images/4.jpg', alt: 'Indri Lemur', name: 'Indri Lemur' },
    { id: 4, src: '/images/5.jpg', alt: 'Bird of Paradise', name: 'Bird of Paradise' },
    { id: 5, src: '/images/6.jpg', alt: 'Madagascar Fish Eagle', name: 'Madagascar Fish Eagle' },
    { id: 6, src: '/images/7.jpg', alt: 'Madagascar Fody', name: 'Madagascar Fody' },
];

const slides = ref([
    {
        src: '/images/1.jpg',
        title: "The Birdwatching Adventure of a Lifetime",
        subtitle: "Discover unique bird species from around the world through our specialized tours.",
        color: "emerald"
    },
    {
        src: '/images/2.jpg',
        title: "Breathtaking Landscapes",
        subtitle: "Explore the diverse fauna and flora of Madagascar.",
        color: "sky"
    },
    {
        src: '/images/3.jpg',
        title: "Guided by Passionate Experts",
        subtitle: "Our local guides take you off the beaten path.",
        color: "amber"
    },
]);

const currentSlide = ref(0);

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % slides.value.length;
};

const prevSlide = () => {
    currentSlide.value = (currentSlide.value - 1 + slides.value.length) % slides.value.length;
};

onMounted(() => {
    // Animate on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-on-scroll').forEach((el) => {
        observer.observe(el);
    });

    // Carousel interval
    setInterval(() => {
        nextSlide();
    }, 7000);
});

</script>

<template>
    <Head title="Home - Momotas Bird" />

    <div class="bg-gray-50 text-slate-800 font-sans antialiased">
        <!-- HEADER -->
        <header class="fixed top-0 w-full bg-white/80 backdrop-blur-lg shadow-sm z-50">
            <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
                <Link href="/" class="text-2xl font-bold text-emerald-600 tracking-tight flex items-center gap-2">
                    <span class="text-3xl">🦜</span>
                    <span>Momotas Bird</span>
                </Link>
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="#itineraires" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Tours</a>
                    <a href="#galerie" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Gallery</a>
                    <a href="#contact" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Contact</a>
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

        <main>
            <!-- HERO CAROUSEL SECTION -->
            <section class="relative h-[600px] md:h-screen text-center overflow-hidden">
                <!-- Slides -->
                <div v-for="(slide, index) in slides" :key="index">
                    <Transition name="fade">
                        <div v-if="currentSlide === index" class="absolute inset-0">
                            <img :src="slide.src" alt="Madagascar Landscape" class="w-full h-full object-cover object-center" />
                            <div class="absolute inset-0 bg-black/60"></div>
                        </div>
                    </Transition>
                </div>

                <!-- Content -->
                <div class="relative h-full flex flex-col items-center justify-center z-10 px-6">
                     <Transition name="slide-up" mode="out-in">
                        <div :key="currentSlide" class="max-w-3xl mx-auto">
                            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 leading-tight">
                                {{ slides[currentSlide].title }} in <span :class="`text-${slides[currentSlide].color}-400`">Madagascar</span>
                            </h1>
                            <p class="text-lg md:text-xl text-gray-200 mb-8">
                                {{ slides[currentSlide].subtitle }}
                            </p>
                            <a href="#itineraires" class="inline-block bg-emerald-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-600 transition-transform transform hover:scale-105 duration-300">
                                Explore Tours
                            </a>
                        </div>
                    </Transition>
                </div>

                <!-- Controls -->
                <button @click="prevSlide" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-white/20 text-white p-2 rounded-full hover:bg-white/40 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <button @click="nextSlide" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-white/20 text-white p-2 rounded-full hover:bg-white/40 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </section>

            <!-- ITINERAIRES SECTION -->
            <section id="itineraires" class="py-20 sm:py-28">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-16 animate-on-scroll">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Our Exceptional Tours</h2>
                        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto [transition-delay:200ms]">Designed by enthusiasts for an immersive and unforgettable experience.</p>
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Card 1 -->
                        <div v-for="c in circuits" :key="c.id" class="animate-on-scroll card-container" style="transition-delay: 0ms;">
                            <div class="card-inner bg-white rounded-xl shadow-lg overflow-hidden">
                                <img :src="'/storage/'+c.image" :alt="c.title" class="w-full h-56 object-cover">
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ c.title }}</h3>
                                    <p class="text-gray-600 mb-4 text-sm line-clamp-1">{{ c.description }}</p>
                                    <div class="flex justify-between items-center">
                                        <Link :href="route('itineraires.show', c.id)" class="text-sm font-semibold text-emerald-600 group-hover:text-emerald-700 transition-colors">View Tour &rarr;</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="flex w-full justify-center">
                <Link class="btn btn-soft btn-sm btn-success" :href="route('itineraires.index')">All itineraires</Link>
            </div>

            <!-- GALERIE SECTION -->
            <section id="galerie" class="py-20 sm:py-28 bg-white">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-16 animate-on-scroll">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Gallery of Winged Treasures</h2>
                        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto [transition-delay:200ms]">A glimpse of the avian beauty you might encounter.</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div v-for="(image, index) in galleryImages" :key="image.id" class="animate-on-scroll group relative rounded-lg overflow-hidden" :style="{ transitionDelay: (index * 100) + 'ms' }">
                            <img :src="image.src" :alt="image.alt" class="w-full h-60 object-cover transform group-hover:scale-110 transition-transform duration-500 ease-in-out" />
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-end p-4">
                                <h3 class="text-white text-lg font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-300">{{ image.name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CONTACT SECTION -->
            <section id="contact" class="py-20 sm:py-28">
                <div class="max-w-4xl mx-auto animate-on-scroll">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 text-center">Ready for Adventure?</h2>
                    <p class="mt-4 text-lg text-gray-600 [transition-delay:200ms] text-center">Contact us to create your custom trip to discover the birds of Madagascar.</p>
                    <div v-if="$page.props.flash && $page.props.flash.success" class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ $page.props.flash.success }}</span>
                    </div>
                    <form @submit.prevent="submit" class="mt-8 max-w-xl mx-auto">
                        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <div class="mt-1">
                                    <input type="text" v-model="form.name" id="name" class="py-3 px-4 block w-full shadow-sm focus:ring-emerald-500 focus:border-emerald-500 border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <div class="mt-1">
                                    <input id="email" v-model="form.email" type="email" class="py-3 px-4 block w-full shadow-sm focus:ring-emerald-500 focus:border-emerald-500 border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                <div class="mt-1">
                                    <textarea id="message" v-model="form.message" rows="4" class="py-3 px-4 block w-full shadow-sm focus:ring-emerald-500 focus:border-emerald-500 border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 sm:col-span-2 text-center">
                            <button type="submit" class="inline-block bg-emerald-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-600 transition-transform transform hover:scale-105 duration-300">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </section>

        </main>

        <!-- FOOTER -->
        <footer class="bg-gray-800 text-white">
            <div class="max-w-7xl mx-auto py-12 px-6 lg:px-8 text-center">
                <p>&copy; {{ new Date().getFullYear() }} Momotas Bird. All rights reserved.</p>
                <p class="text-sm text-gray-400 mt-2">Your specialist in birdwatching trips in Madagascar.</p>
            </div>
        </footer>
    </div>
</template>

<style>
.animate-on-scroll {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.animate-on-scroll.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* Carousel Transitions */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 1.5s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-up-enter-active,
.slide-up-leave-active {
    transition: all 0.5s ease-out;
}
.slide-up-enter-from {
    opacity: 0;
    transform: translateY(20px);
}
.slide-up-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}

/* 3D Card Effect */
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


/* Tailwind CSS JIT classes - these are here to ensure they are generated */
.text-emerald-400 {}
.text-sky-400 {}
.text-amber-400 {}
</style>