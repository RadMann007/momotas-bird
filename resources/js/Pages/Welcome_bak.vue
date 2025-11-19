<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

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

const messageSent = ref(false);

const submit = () => {
    form.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            messageSent.value = true;
            setTimeout(() => {
                messageSent.value = false;
            }, 4000);
        },
    });
};

const isMobileMenuOpen = ref(false);

const galleryImages = [
    { id: 1, src: '/images/2.jpg', alt: 'Van Dam\'s Vanga', name: 'Van Dam\'s Vanga' },
    { id: 2, src: '/images/3.jpg', alt: 'Blue Coua', name: 'Blue Coua' },
    { id: 3, src: '/images/4.jpg', alt: 'Indri Lemur', name: 'Indri Lemur' },
    { id: 4, src: '/images/5.jpg', alt: 'Bird of Paradise', name: 'Bird of Paradise' },
    { id: 5, src: '/images/6.jpg', alt: 'Madagascar Fish Eagle', name: 'Madagascar Fish Eagle' },
    { id: 6, src: '/images/7.jpg', alt: 'Madagascar Fody', name: 'Madagascar Fody' },
];

const carouselSlides = ref([
    { 
        src: '/images/1.jpg', 
        title: 'MOMOTAS', 
        name: 'BIRD', 
        des: 'Your specialist in birdwatching trips in Madagascar.' 
    },
    { 
        src: '/images/2.jpg', 
        title: 'Discover', 
        name: 'Van Dam\'s Vanga', 
        des: 'One of Madagascar\'s most elusive and sought-after birds.' 
    },
    { 
        src: '/images/3.jpg', 
        title: 'Explore', 
        name: 'Blue Coua', 
        des: 'A stunningly vibrant bird, often seen foraging on the forest floor.' 
    },
    { 
        src: '/images/4.jpg', 
        title: 'Witness', 
        name: 'Indri Lemur', 
        des: 'The haunting calls of the Indri are an unforgettable part of the forest.' 
    },
    { 
        src: '/images/5.jpg', 
        title: 'Marvel at', 
        name: 'Bird of Paradise', 
        des: 'Known for its spectacular plumage and elaborate mating dances.' 
    },
    { 
        src: '/images/6.jpg', 
        title: 'Seek out', 
        name: 'Madagascar Fish Eagle', 
        des: 'A majestic and critically endangered raptor from the western coast.' 
    },
    { 
        src: '/images/7.jpg', 
        title: 'Spot the', 
        name: 'Madagascar Fody', 
        des: 'The brilliant red of the male Fody is a common and beautiful sight.' 
    },
]);

const carousel = ref(null);
const list = ref(null);
const runningTime = ref(null);
const nextBtn = ref(null);
const prevBtn = ref(null);

let timeRunning = 3000;
let timeAutoNext = 7000;
let runTimeOut;
let runNextAuto;

const showSlider = (type) => {
    if (!list.value) return;
    let sliderItemsDom = list.value.querySelectorAll('.carousel .list .item');
    if (type === 'next') {
        list.value.appendChild(sliderItemsDom[0]);
        carousel.value.classList.add('next');
    } else {
        list.value.prepend(sliderItemsDom[sliderItemsDom.length - 1]);
        carousel.value.classList.add('prev');
    }

    clearTimeout(runTimeOut);
    runTimeOut = setTimeout(() => {
        carousel.value.classList.remove('next');
        carousel.value.classList.remove('prev');
    }, timeRunning);

    clearTimeout(runNextAuto);
    runNextAuto = setTimeout(() => {
        if (nextBtn.value) {
            nextBtn.value.click();
        }
    }, timeAutoNext);

    resetTimeAnimation();
};

const resetTimeAnimation = () => {
    if (runningTime.value) {
        runningTime.value.style.animation = 'none';
        runningTime.value.offsetHeight; // trigger reflow
        runningTime.value.style.animation = null;
        runningTime.value.style.animation = 'runningTime 7s linear 1 forwards';
    }
};

onMounted(() => {
    // Carousel logic
    if (nextBtn.value) {
        nextBtn.value.onclick = () => showSlider('next');
    }
    if (prevBtn.value) {
        prevBtn.value.onclick = () => showSlider('prev');
    }
    runNextAuto = setTimeout(() => {
        if (nextBtn.value) {
            nextBtn.value.click();
        }
    }, timeAutoNext);
    resetTimeAnimation();

    // Animate on scroll from Welcome_bak.vue
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
});

</script>

<template>
    <Head title="Momotas Bird" />

    <div class="font-sans antialiased bg-gray-50 text-slate-800">
        <!-- HEADER -->
        <header class="fixed top-0 w-full bg-white/80 backdrop-blur-lg shadow-sm z-50">
            <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
                <Link href="/" class="text-2xl font-bold text-emerald-600 tracking-tight flex items-center gap-2">
                    <img src="/images/logo.png" class="size-16"/>
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
                        <Link v-if="canRegister" :href="route('register')" 
                        class="btn btn-success btn-outline">
                            Register
                        </Link>
                    </template>
                     <Link v-else :href="route('dashboard')" class="text-sm font-medium text-emerald-600 hover:underline">
                        Dashboard
                    </Link>
                </div>
                <!-- Hamburger Button -->
                <div class="md:hidden">
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="text-gray-600 hover:text-emerald-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div v-show="isMobileMenuOpen" class="md:hidden bg-white/95 backdrop-blur-lg">
                <nav class="px-2 pt-2 pb-4 space-y-1 sm:px-3">
                    <a href="#itineraires" @click="isMobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Tours</a>
                    <a href="#galerie" @click="isMobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Gallery</a>
                    <a href="#contact" @click="isMobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Contact</a>
                </nav>
                <div class="px-5 py-4 border-t border-gray-200">
                    <template v-if="!$page.props.auth.user">
                        <Link v-if="canLogin" :href="route('login')" @click="isMobileMenuOpen = false" class="block w-full text-left text-base font-medium text-gray-600 hover:text-emerald-600 mb-3">Log in</Link>
                        <Link v-if="canRegister" :href="route('register')" @click="isMobileMenuOpen = false" class="block w-full text-center text-base font-bold bg-emerald-500 text-white px-4 py-2 rounded-full hover:bg-emerald-600">
                            Register
                        </Link>
                    </template>
                    <Link v-else :href="route('dashboard')" @click="isMobileMenuOpen = false" class="block w-full text-left text-base font-medium text-emerald-600 hover:underline">
                        Dashboard
                    </Link>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <div class="relative">
            <!-- Mobile Hero -->
            <div class="md:hidden">
                <div class="relative h-[90vh] bg-cover bg-center" :style="{ backgroundImage: `url(/images/1.jpg)` }">
                    <div class="absolute inset-0 bg-black/50"></div>
                    <div class="absolute inset-0 flex flex-col justify-center items-center text-center text-white p-6">
                        <h1 class="text-4xl font-bold leading-tight">
                            <span class="text-emerald-400">MOMOTAS</span>
                            <span class="block">BIRD</span>
                        </h1>
                        <p class="mt-4 text-lg max-w-xs">
                            Your specialist in birdwatching trips in Madagascar.
                        </p>
                        <a href="#contact" class="btn btn-success btn-outline mt-8">
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop Carousel Section -->
        <div class="hidden md:block pt-24 pb-12">
            <div class="max-w-screen-xl mx-auto">
                <div class="carousel relative rounded-2xl shadow-2xl overflow-hidden" ref="carousel" style="height: 65vh; max-height: 600px;">
                    <div class="list" ref="list">
                        <div class="item" v-for="(slide, index) in carouselSlides" :key="index">
                            <div class="bg-image" :style="{ backgroundImage: `url(${slide.src})` }"></div>
                            <div class="content">
                                <div class="title">{{ slide.title }}</div>
                                <div class="name">{{ slide.name }}</div>
                                <div class="des">{{ slide.des }}</div>
                                <div class="">
                                    <a href="#contact" class="btn btn-success btn-outline">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="arrows">
                        <button class="prev" ref="prevBtn"><</button>
                        <button class="next" ref="nextBtn">></button>
                    </div>
                    <div class="timeRunning" ref="runningTime"></div>
                </div>
            </div>
        </div>

        <main>
            <!-- ITINERAIRES SECTION -->
            <section id="itineraires" class="py-16 md:py-28">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-12 md:mb-16 animate-on-scroll">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Our Exceptional Tours</h2>
                        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto [transition-delay:200ms]">Designed by enthusiasts for an immersive and unforgettable experience.</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div v-for="c in circuits" :key="c.id" class="animate-on-scroll card-container" style="transition-delay: 0ms;">
                            <div class="card-inner bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                                <img :src="'/storage/'+c.image" :alt="c.title" loading="lazy" class="w-full h-56 object-cover">
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ c.title }}</h3>
                                    <p class="text-gray-600 mb-4 text-sm line-clamp-2">{{ c.description }}</p>
                                    <div class="flex justify-between items-center">
                                        <Link :href="route('itineraires.show', c.id)" class="text-sm font-semibold text-emerald-600 group-hover:text-emerald-700 transition-colors">View Tour &rarr;</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="flex w-full justify-center py-8">
                <Link class="bg-emerald-500 text-white px-6 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-600 transition-transform transform hover:scale-105 duration-300" :href="route('itineraires.index')">All itineraires</Link>
            </div>

            <!-- GALERIE SECTION -->
            <section id="galerie" class="py-16 md:py-28 bg-white">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-12 md:mb-16 animate-on-scroll">
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
            <section id="contact" class="py-16 md:py-28">
                <div class="max-w-4xl mx-auto px-6 lg:px-8 animate-on-scroll">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 text-center">Ready for Adventure?</h2>
                    <p class="mt-4 text-lg text-gray-600 [transition-delay:200ms] text-center">Contact us to create your custom trip to discover the birds of Madagascar.</p>
                    <div v-if="$page.props.flash && $page.props.flash.success" class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ $page.props.flash.success }}</span>
                    </div>
                    <div v-if="messageSent" class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">Your message has been sent successfully!</span>
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
                            <button :disabled="form.processing" type="submit" class="inline-block bg-emerald-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-600 transition-transform transform hover:scale-105 duration-300 disabled:opacity-50">
                                <span v-if="form.processing">Sending...</span>
                                <span v-else>Send Message</span>
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

<style scoped>
/* @import './slider.css'; */

.list .item .content{
    position: absolute;
    top: 50%;
    left: 100px;
    transform: translateY(-50%);
    width: 550px;
    text-align: left;
    color: #fff;
    display: none;
}

.content .title,
.content .name,
.content .des,
.content .btn {
    opacity: 0;
    animation: animate 1s ease-in-out 1 forwards;
}

.content .name { animation-delay: 0.3s; }
.content .des { animation-delay: 0.6s; }
.content .btn { animation-delay: 0.9s; }

.title {
    font-size: 50px;
    text-transform: uppercase;
    color: #fff;
    font-weight: bold;
    line-height: 1;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.name {
    font-size: 50px;
    text-transform: uppercase;
    font-weight: bold;
    line-height: 1;
    color: #fff;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.des {
    margin-top: 10px;
    margin-bottom: 20px;
    font-size: 16px;
    margin-left: 5px;
    color: #eee;
    text-shadow: 0 1px 3px rgba(0,0,0,0.4);
}

.btn {
    margin-left: 5px;
}

</style>

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
</style>