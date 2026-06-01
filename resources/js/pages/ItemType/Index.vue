<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { home } from '@/routes/index';
import { create, edit } from '@/routes/item_types';
import { ItemType } from '@/types/item-type';

interface Props {
  itemTypes: ItemType[];
}

const props = defineProps<Props>();

const hasTypes = computed(() => props.itemTypes.length > 0);

function categoryBadgeClass(categoryId: string): string {
  switch (categoryId) {
    case 'operating':
      return 'bg-emerald-100 text-emerald-800';
    case 'investing':
      return 'bg-sky-100 text-sky-800';
    case 'financing':
      return 'bg-violet-100 text-violet-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
}
</script>

<template>
  <Head title="Item types" />

  <div class="min-h-screen bg-gray-50 py-8 text-gray-900">
    <div class="mx-auto max-w-5xl space-y-8 px-4 sm:px-6 lg:px-8">
      <nav class="flex flex-wrap items-center justify-between gap-4">
        <Link
          :href="home()"
          class="inline-flex items-center gap-1 text-sm font-medium text-emerald-800 hover:text-emerald-950 hover:underline"
        >
          <span aria-hidden="true">&larr;</span>
          Back to Cashflow
        </Link>
        <Link
          :href="create()"
          class="inline-flex items-center justify-center rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white shadow-xs transition hover:bg-emerald-800 focus:ring-2 focus:ring-emerald-500/40 focus:outline-none"
        >
          Create type
        </Link>
      </nav>

      <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <header class="border-b border-emerald-800/20 bg-emerald-700 px-6 py-6 text-white sm:px-8">
          <p class="text-xs font-semibold tracking-[0.2em] text-emerald-100 uppercase">
            Cashflow
          </p>
          <h1 class="mt-2 text-2xl font-semibold tracking-tight">Item types</h1>
          <p class="mt-2 max-w-2xl text-sm text-emerald-100">
            Line types grouped by operating, investing, and financing activities on your statement.
          </p>
        </header>

        <div v-if="!hasTypes" class="px-6 py-12 text-center sm:px-8">
          <p class="text-sm text-gray-600">No item types yet.</p>
          <Link
            :href="create()"
            class="mt-4 inline-flex text-sm font-medium text-emerald-700 hover:text-emerald-900 hover:underline"
          >
            Create your first type
          </Link>
        </div>

        <div v-else class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead>
              <tr class="border-b border-gray-200 bg-emerald-50/80">
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-emerald-900 uppercase"
                >
                  Code
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-emerald-900 uppercase"
                >
                  Name
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-emerald-900 uppercase"
                >
                  Description
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-emerald-900 uppercase"
                >
                  Category
                </th>
                <th scope="col" class="px-4 py-3">
                  <span class="sr-only">Actions</span>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr
                v-for="itemType in props.itemTypes"
                :key="itemType.id"
                class="hover:bg-gray-50/80"
              >
                <td class="px-4 py-3 font-mono text-sm font-medium text-gray-900">
                  {{ itemType.code }}
                </td>
                <td class="px-4 py-3 font-medium text-gray-900">
                  {{ itemType.name }}
                </td>
                <td
                  class="max-w-md truncate px-4 py-3 text-gray-700"
                  :title="itemType.description"
                >
                  {{ itemType.description }}
                </td>
                <td class="px-4 py-3">
                  <span
                    class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium"
                    :class="categoryBadgeClass(itemType.category.id)"
                  >
                    {{ itemType.category.label }}
                  </span>
                </td>
                <td class="px-4 py-3 text-right">
                  <Link
                    :href="edit({ itemType: itemType.id })"
                    class="font-medium text-emerald-700 hover:text-emerald-900 hover:underline"
                  >
                    Edit
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <footer
          v-if="hasTypes"
          class="border-t border-gray-100 bg-gray-50 px-6 py-3 text-sm text-gray-600 sm:px-8"
        >
          {{ props.itemTypes.length }} type{{ props.itemTypes.length === 1 ? '' : 's' }}
        </footer>
      </section>
    </div>
  </div>
</template>
