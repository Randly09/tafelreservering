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
    <div class="min-h-screen flex items-center justify-center ">
      <div class="w-full max-w-md bg-white dark:bg-gray-700 p-8 rounded-xl shadow-lg">
        <h2 class="text-center text-2xl font-bold text-gray-800 dark:text-white mb-6">
          Create an Account
        </h2>

        <form @submit.prevent="submit">
          <div class="mb-4">
            <InputLabel for="name" value="Name" class="text-gray-700 dark:text-gray-300" />
            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500"
              v-model="form.name"
              required
              autofocus
              autocomplete="name"
            />
            <InputError class="mt-2" :message="form.errors.name" />
          </div>

          <div class="mb-4">
            <InputLabel for="email" value="Email" class="text-gray-700 dark:text-gray-300" />
            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500"
              v-model="form.email"
              required
              autocomplete="username"
            />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <div class="mb-4">
            <InputLabel for="password" value="Password" class="text-gray-700 dark:text-gray-300" />
            <TextInput
              id="password"
              type="password"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500"
              v-model="form.password"
              required
              autocomplete="new-password"
            />
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <div class="mb-4">
            <InputLabel for="password_confirmation" value="Confirm Password" class="text-gray-700 dark:text-gray-300" />
            <TextInput
              id="password_confirmation"
              type="password"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500"
              v-model="form.password_confirmation"
              required
              autocomplete="new-password"
            />
            <InputError class="mt-2" :message="form.errors.password_confirmation" />
          </div>

          <div class="flex items-center justify-end">
            <Link
              :href="route('login')"
              class="text-sm text-blue-600 hover:underline dark:text-blue-400"
            >
              Already registered?
            </Link>
            <PrimaryButton
              class="ml-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Register
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </GuestLayout>
</template>