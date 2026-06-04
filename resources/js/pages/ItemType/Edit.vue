<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { index, update } from '@/routes/item_types';
import { Category } from '@/types/category';
import { ItemType, ItemTypeError } from '@/types/item-type';

interface Props {
  itemType: ItemType;
  categories: Category[];
  errors: ItemTypeError;
}

const props = defineProps<Props>();

const updateRoute = update({ itemType: props.itemType.id });

const form = useForm({
  category: props.itemType.category.id,
  code: props.itemType.code,
  name: props.itemType.name,
  description: props.itemType.description,
});

</script>

<template>
  <Head title="Edit item type" />

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
          <h1 class="mt-2 text-2xl font-semibold tracking-tight">Edit item type</h1>
          <p class="mt-2 max-w-xl text-sm text-emerald-100">
            Update this line type and how it appears on your cashflow statement.
          </p>
        </header>

        <form
          class="space-y-8 px-6 py-6 sm:px-8"
          @submit.prevent="form.submit(updateRoute.method, updateRoute.url)"
        >
          <fieldset class="space-y-5">
            <legend class="text-sm font-semibold text-gray-900">Classification</legend>

            <div>
              <label for="category" class="block form-label">
                Category
              </label>
                <p id="category" class="mt-2 block w-full form-input" style="background-color: #f0f0f0">
                  {{ props.itemType.category.label }}
                </p>
            </div>
          </fieldset>

          <fieldset class="space-y-5 border-t border-gray-100 pt-8">
            <legend class="text-sm font-semibold text-gray-900">Type details</legend>

            <div class="grid gap-5 sm:grid-cols-2">
              <div>
                <label for="code" class="block form-label">Code</label>
                <p id="code" class="mt-2 block w-full form-input" style="background-color: #f0f0f0">
                  {{ props.itemType.code }}
                </p>
              </div>

              <div>
                <label for="name" class="block form-label">Name</label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  maxlength="255"
                  required
                  autocomplete="off"
                  class="mt-2 block w-full form-input"
                />
                <p v-if="props.errors.name" class="mt-2 form-error">
                  {{ props.errors.name }}
                </p>
              </div>
            </div>

            <div>
              <label for="description" class="block form-label">
                Description
              </label>
              <textarea
                id="description"
                v-model="form.description"
                maxlength="2000"
                required
                rows="5"
                autocomplete="off"
                class="mt-2 block w-full form-textarea"
              />
              <p v-if="props.errors.description" class="mt-2 form-error">
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
              <span v-if="form.processing">Saving…</span>
              <span v-else>Save changes</span>
            </button>
          </div>
        </form>
      </section>
    </div>
  </div>
</template>
