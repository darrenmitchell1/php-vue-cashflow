<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { index, store } from '@/routes/item_types';
import { Category } from '@/types/category';
import { ItemTypeError } from '@/types/item-type';
import { toAlphaDash } from '@/lib/text-formatters.js'

interface Props {
  categories: Category[];
  errors: ItemTypeError;
}

const props = defineProps<Props>();

const form = useForm({
  category: null as string | null,
  code: null as string | null,
  name: null as string | null,
  description: null as string | null,
});

const inputClass =
  'mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-xs focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none';

const selectClass =
  'mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-xs focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none';

function handleFormCodeChange(): void {
    form.code = toAlphaDash(form.code);
}
</script>

<template>
  <Head title="Create item type" />

  <div class="min-h-screen bg-gray-50 py-8 text-gray-900">
    <div class="mx-auto max-w-3xl space-y-8 px-4 sm:px-6 lg:px-8">
      <nav>
        <Link
          :href="index()"
          class="inline-flex items-center gap-1 text-sm font-medium text-emerald-800 hover:text-emerald-950 hover:underline"
        >
          <span aria-hidden="true">&larr;</span>
          Back to types
        </Link>
      </nav>

      <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <header class="border-b border-emerald-800/20 bg-emerald-700 px-6 py-6 text-white sm:px-8">
          <p class="text-xs font-semibold tracking-[0.2em] text-emerald-100 uppercase">
            Cashflow
          </p>
          <h1 class="mt-2 text-2xl font-semibold tracking-tight">Create item type</h1>
          <p class="mt-2 max-w-xl text-sm text-emerald-100">
            Define a line type grouped under operating, investing, or financing activities.
          </p>
        </header>

        <form
          class="space-y-8 px-6 py-6 sm:px-8"
          @submit.prevent="
            form.submit(store().method, store().url, {
              preserveState: true,
              except: ['categories'],
            })
          "
        >
          <fieldset class="space-y-5">
            <legend class="text-sm font-semibold text-gray-900">Classification</legend>

            <div>
              <label for="category" class="block text-sm font-medium text-gray-700">
                Category
              </label>
              <select id="category" v-model="form.category" required :class="selectClass">
                <option disabled value="">Select a category…</option>
                <option
                  v-for="category in props.categories"
                  :key="category.id"
                  :value="category.id"
                >
                  {{ category.label }}
                </option>
              </select>
              <p v-if="props.errors.category" class="mt-2 text-sm text-red-600">
                {{ props.errors.category }}
              </p>
            </div>
          </fieldset>

          <fieldset class="space-y-5 border-t border-gray-100 pt-8">
            <legend class="text-sm font-semibold text-gray-900">Type details</legend>

            <div class="grid gap-5 sm:grid-cols-2">
              <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                <input
                  id="code"
                  v-model="form.code"
                  type="text"
                  maxlength="255"
                  required
                  autofocus
                  autocomplete="off"
                  :class="inputClass"
                  @blur="handleFormCodeChange()"
                />
                <p v-if="props.errors.code" class="mt-2 text-sm text-red-600">
                  {{ props.errors.code }}
                </p>
              </div>

              <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  maxlength="255"
                  required
                  autocomplete="off"
                  :class="inputClass"
                />
                <p v-if="props.errors.name" class="mt-2 text-sm text-red-600">
                  {{ props.errors.name }}
                </p>
              </div>
            </div>

            <div>
              <label for="description" class="block text-sm font-medium text-gray-700">
                Description
              </label>
              <textarea
                id="description"
                v-model="form.description"
                maxlength="2000"
                required
                rows="5"
                autocomplete="off"
                class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-xs focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none"
              />
              <p v-if="props.errors.description" class="mt-2 text-sm text-red-600">
                {{ props.errors.description }}
              </p>
            </div>
          </fieldset>

          <div class="flex flex-wrap items-center justify-end gap-3 border-t border-gray-100 pt-6">
            <Link
              :href="index()"
              class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-xs transition hover:bg-gray-50 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none"
            >
              Cancel
            </Link>
            <button
              type="submit"
              :disabled="form.processing"
              class="inline-flex items-center justify-center rounded-md bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white shadow-xs transition hover:bg-emerald-800 focus:ring-2 focus:ring-emerald-500/40 focus:outline-none disabled:cursor-not-allowed disabled:opacity-60"
            >
              <span v-if="form.processing">Creating…</span>
              <span v-else>Create type</span>
            </button>
          </div>
        </form>
      </section>
    </div>
  </div>
</template>
