<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="relative min-h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url('/images/1.jpg');">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 max-w-md w-full mx-auto p-8 bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl">
            <div class="text-center mb-8">
                <Link href="/">
                    <img src="/images/logo.png" class="h-24 w-auto mx-auto"/>
                </Link>
            </div>
            <slot />
        </div>
    </div>
</template>
