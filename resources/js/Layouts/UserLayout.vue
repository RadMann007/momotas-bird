<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    noPadding: {
        type: Boolean,
        default: false,
    }
});

const isMobileMenuOpen = ref(false);
</script>

<template>
    <div class="font-sans antialiased bg-gray-50 text-slate-800">
        <!-- HEADER -->
        <header class="sticky top-0 w-full bg-white/80 backdrop-blur-lg shadow-sm z-50">
            <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
                <Link href="/" class="text-2xl font-bold text-emerald-600 tracking-tight flex items-center gap-2">
                    <img src="/images/logo.png" class="size-16"/>
                    <span>Momotas Bird</span>
                </Link>
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <Link href="/#itineraires" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Tours</Link>
                    <Link href="/#galerie" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Gallery</Link>
                    <Link href="/#about" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">About</Link>
                    <Link href="/#testimonials" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Testimonials</Link>
                    <Link href="/#contact" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Contact</Link>
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
                    <Link href="/#itineraires" @click="isMobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Tours</Link>
                    <Link href="/#galerie" @click="isMobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Gallery</Link>
                    <Link href="/#about" @click="isMobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-emerald-600 hover:bg-gray-50">About</Link>
                    <Link href="/#testimonials" @click="isMobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Testimonials</Link>
                    <Link href="/#contact" @click="isMobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Contact</Link>
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

        <main :class="{ 'pt-24': !noPadding }">
            <slot />
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
