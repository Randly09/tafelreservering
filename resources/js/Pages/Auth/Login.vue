<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Log in" />
    <div class="min-h-screen flex items-center justify-center ">
      <div class="w-full max-w-md bg-white dark:bg-gray-700 p-8 rounded-xl shadow-lg">
        <h2 class="text-center text-2xl font-bold text-gray-800 dark:text-white mb-6">
          Log in to Your Account
        </h2>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
          {{ status }}
        </div>

        <form @submit.prevent="submit">
          <div class="mb-4">
            <InputLabel for="email" value="Email" class="text-gray-700 dark:text-gray-300" />
            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500"
              v-model="form.email"
              required
              autofocus
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
              autocomplete="current-password"
            />
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <div class="flex items-center justify-between mb-6">
            <label class="flex items-center">
              <Checkbox name="remember" v-model:checked="form.remember" class="mr-2" />
              <span class="text-sm text-gray-700 dark:text-gray-300">Remember me</span>
            </label>
            <Link
              v-if="canResetPassword"
              :href="route('password.request')"
              class="text-sm text-blue-600 hover:underline dark:text-blue-400"
            >
              Forgot your password?
            </Link>
          </div>

          <div class="flex justify-end">
            <PrimaryButton
              class="ml-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Log in
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </GuestLayout>
</template>