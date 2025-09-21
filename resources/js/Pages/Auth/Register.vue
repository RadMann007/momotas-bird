<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <h2 class="text-2xl font-bold text-gray-900 text-center">Create your account</h2>

        <form @submit.prevent="submit" class="mt-8 space-y-6">
            <div>
                <InputLabel for="name" value="Name" class="text-gray-700" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Your Name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" class="text-gray-700" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="you@example.com"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Password" class="text-gray-700" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Confirm Password" class="text-gray-700" />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div>
                <PrimaryButton
                    class="w-full justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>

        <p class="mt-8 text-center text-sm text-gray-600">
            Already have an account?
            <Link :href="route('login')" class="font-medium text-emerald-600 hover:underline">
                Sign in
            </Link>
        </p>
    </GuestLayout>
</template>