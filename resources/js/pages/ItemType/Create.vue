<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { index, store } from '@/routes/item_types';
import { Category } from '@/types/category';
import { ItemTypeError } from '@/types/item-type';

interface Props {
  categories: Category[],
  errors: ItemTypeError,
}

const props = defineProps<Props>();

const form = useForm({
    category: null,
    code: null,
    name: null,
    description: null,
});
</script>

<template>
  <Head title="Item Types" />
  
  <div style="margin-top: 50px; margin-left: 50px;">
    <Link
      :href="index()"
      class="inline-block px-5 py-1.5 hover:text-gray-700 hover:underline"
    >
        Types
    </Link>
  </div>

  <div class="py-12">
    <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 bg-white p-4 shadow-sm sm:rounded-lg sm:p-8 w-1/3">
      <form @submit.prevent="form.submit(store().method, store().url, {preserveState: true, except: ['categories']})">
        
        <label for="category" class="mt-10 block text-sm font-medium text-gray-700">Category</label>
        <select v-model="form.category" required class="w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500">
            <option v-for="category in props.categories" :id="category.id" :value="category.id" class="break-words whitespace-normal">
                {{ category.label }}
            </option>
        </select>
        <p class="input-error mt-2" v-if="props.errors.category">{{ props.errors.category }}</p>

        <label for="code" class="mt-10 block text-sm font-medium text-gray-700">Code</label>
        <input
            id="code"
            type="text"
            maxlength="255"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500"
            v-model="form.code"
            required
            autofocus
            autocomplete="code"
        />
        <p class="input-error mt-2" v-if="props.errors.code">{{ props.errors.code }}</p>

        <label for="name" class="mt-10 block text-sm font-medium text-gray-700">Name</label>
        <input
            id="name"
            type="text"
            maxlength="255"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500"
            v-model="form.name"
            required
            autofocus
            autocomplete="name"
        />
        <p class="input-error mt-2" v-if="props.errors.name">{{ props.errors.name }}</p>

        <label for="description" class="mt-10 block text-sm font-medium text-gray-700">Description</label>
        <textarea
            id="description"
            type="text"
            maxlength="2000"
            class="mt-1 min-h-60 w-full rounded-md border border-gray-300"
            v-model="form.description"
            required
            autocomplete="description"
        />
        <p class="input-error mt-2" v-if="props.errors.description">{{ props.errors.description }}</p>

        <div class="mt-4 flex items-center justify-end">
            <button type="submit">Create</button>
        </div>
        
      </form>
    </div>
  </div>
</template>