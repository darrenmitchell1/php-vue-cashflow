<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { index } from '@/routes/item_types';
import { store } from '@/routes/item_types';

const props = defineProps({
    categories: {
        type: JSON,
        required: true,
    },
});

const form = useForm({
    category: null,
    code: null,
    name: null,
    description: null,
});
</script>

<template>
  <Head title="Item Types" />
  <Link
      :href="index()"
      class="inline-block px-5 py-1.5"
  >
      Types
  </Link>
  <div class="py-12">
    <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 bg-white p-4 shadow-sm sm:rounded-lg sm:p-8 w-1/3">
      <form :action="store()">
        <InputLabel for="category" value="Category" class="mt-10"/>
          <select v-model="form.category" class="w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500">
              <option v-for="category in props.categories" :id="category.id" :value="category.id" class="break-words whitespace-normal">
                  {{ category.label }}
              </option>
          </select>
          <InputError v-if="form.errors.category" class="mt-2" :message="form.errors.category" />

          <InputLabel for="code" value="Code" class="mt-10"/>
          <TextInput
              id="code"
              type="text"
              maxlength="255"
              class="mt-1 block w-full"
              v-model="form.code"
              required
              autofocus
              autocomplete="code"
          />
          <InputError v-if="form.errors.code" class="mt-2" :message="form.errors.code" />

          <InputLabel for="name" value="Name" class="mt-10"/>
          <TextInput
              id="name"
              type="text"
              maxlength="255"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              autofocus
              autocomplete="name"
          />
          <InputError v-if="form.errors.name" class="mt-2" :message="form.errors.name" />

          <InputLabel for="description" value="Description" class="mt-10"/>
          <textarea
              id="description"
              type="text"
              class="mt-1 min-h-60 w-full rounded-md border border-gray-300"
              v-model="form.description"
              required
              autocomplete="description"
          />
          <InputError v-if="form.errors.description" class="mt-2" :message="form.errors.description" />

          <div class="mt-4 flex items-center justify-end">
            <button type="submit">Create</button>
          </div>
      </form>
    </div>
  </div>
</template>