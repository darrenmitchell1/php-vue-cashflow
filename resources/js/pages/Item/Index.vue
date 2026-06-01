<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { home } from '@/routes/index';
import { create, edit } from '@/routes/items';
import { Item } from '@/types/item';

interface Props {
  items: Item[];
}

const props = defineProps<Props>();

const hasItems = computed(() => props.items.length > 0);

function formatDate(iso: string): string {
  return new Date(iso).toLocaleDateString('en-AU', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
  });
}

function formatMoney(value: number | string): string {
  const amount = Number(value);
  return new Intl.NumberFormat('en-AU', {
    style: 'currency',
    currency: 'AUD',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(Number.isFinite(amount) ? amount : 0);
}

function isInflow(item: Item): boolean {
  return item.flow.id === 'in' || item.flow.label?.toLowerCase() === 'in';
}
</script>

<template>
  <Head title="Items" />

  <div class="min-h-screen bg-gray-50 py-8 text-gray-900">
    <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
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
          Create item
        </Link>
      </nav>

      <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <header class="border-b border-emerald-800/20 bg-emerald-700 px-6 py-6 text-white sm:px-8">
          <p class="text-xs font-semibold tracking-[0.2em] text-emerald-100 uppercase">
            Cashflow
          </p>
          <h1 class="mt-2 text-2xl font-semibold tracking-tight">Items</h1>
          <p class="mt-2 max-w-2xl text-sm text-emerald-100">
            Recurring and one-off cashflow items that generate transactions for your statement.
          </p>
        </header>

        <div v-if="!hasItems" class="px-6 py-12 text-center sm:px-8">
          <p class="text-sm text-gray-600">No items yet.</p>
          <Link
            :href="create()"
            class="mt-4 inline-flex text-sm font-medium text-emerald-700 hover:text-emerald-900 hover:underline"
          >
            Create your first item
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
                  Type
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-emerald-900 uppercase"
                >
                  Flow
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-emerald-900 uppercase"
                >
                  Frequency
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-emerald-900 uppercase"
                >
                  Start date
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-right text-xs font-semibold tracking-wide text-emerald-900 uppercase"
                >
                  Transactions
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
                  Company
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-right text-xs font-semibold tracking-wide text-emerald-900 uppercase"
                >
                  Amount
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-emerald-900 uppercase"
                >
                  Reference
                </th>
                <th scope="col" class="px-4 py-3">
                  <span class="sr-only">Actions</span>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr v-for="item in props.items" :key="item.id" class="hover:bg-gray-50/80">
                <td class="px-4 py-3 font-medium text-gray-900">
                  <span v-if="item.item_type">{{ item.item_type.name }}</span>
                  <span v-else class="text-gray-400 italic">—</span>
                </td>
                <td class="px-4 py-3">
                  <span
                    class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium"
                    :class="
                      isInflow(item)
                        ? 'bg-emerald-100 text-emerald-800'
                        : 'bg-red-100 text-red-800'
                    "
                  >
                    {{ item.flow.label }}
                  </span>
                </td>
                <td class="px-4 py-3 text-gray-700">{{ item.frequency.label }}</td>
                <td class="px-4 py-3 text-gray-700 tabular-nums">
                  {{ formatDate(item.start_date) }}
                </td>
                <td class="px-4 py-3 text-right text-gray-700 tabular-nums">
                  {{ item.number_of_transactions }}
                </td>
                <td class="max-w-[12rem] truncate px-4 py-3 text-gray-700" :title="item.description">
                  {{ item.description }}
                </td>
                <td class="max-w-[10rem] truncate px-4 py-3 text-gray-700" :title="item.company_name">
                  {{ item.company_name }}
                </td>
                <td class="px-4 py-3 text-right font-medium text-gray-900 tabular-nums">
                  {{ formatMoney(item.amount) }}
                </td>
                <td class="max-w-[8rem] truncate px-4 py-3 text-gray-600">
                  {{ item.reference ?? '—' }}
                </td>
                <td class="px-4 py-3 text-right">
                  <Link
                    :href="edit({ item: item.id })"
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
          v-if="hasItems"
          class="border-t border-gray-100 bg-gray-50 px-6 py-3 text-sm text-gray-600 sm:px-8"
        >
          {{ props.items.length }} item{{ props.items.length === 1 ? '' : 's' }}
        </footer>
      </section>
    </div>
  </div>
</template>
