<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import ItemTypeController from '@/actions/App/Http/Controllers/ItemTypeController';
import items from '@/routes/items';
import statement from '@/routes/statement';

const sections = [
  {
    title: 'Item types',
    description: 'Define cashflow categories and line types used when recording transactions.',
    href: ItemTypeController.index(),
    cta: 'Manage types',
  },
  {
    title: 'Items',
    description: 'Create recurring or one-off cashflow items and generate their transactions.',
    href: items.index(),
    cta: 'Manage items',
  },
  {
    title: 'Statement',
    description: 'Generate a statement of cash flows for any reporting period.',
    href: statement.index(),
    cta: 'View statement',
  },
];
</script>

<template>
  <Head title="Cashflow" />

  <div class="min-h-screen bg-gray-50 py-8 text-gray-900">
    <div class="mx-auto max-w-4xl space-y-8 px-4 sm:px-6 lg:px-8">
      <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <header class="border-b border-emerald-800/20 bg-emerald-700 px-6 py-8 text-white sm:px-8">
          <p class="text-xs font-semibold tracking-[0.2em] text-emerald-100 uppercase">
            Cashflow
          </p>
          <h1 class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl">
            Cashflow management
          </h1>
          <p class="mt-3 max-w-2xl text-sm leading-relaxed text-emerald-100">
            Record item transactions against pre-defined types, then produce a statement of cash
            flows for any period.
          </p>
        </header>

        <div class="grid gap-4 p-6 sm:grid-cols-3 sm:p-8">
          <Link
            v-for="section in sections"
            :key="section.title"
            :href="section.href"
            class="group flex flex-col rounded-lg border border-gray-200 bg-gray-50/50 p-5 transition hover:border-emerald-300 hover:bg-emerald-50/50 hover:shadow-sm focus:ring-2 focus:ring-emerald-500/40 focus:outline-none"
          >
            <h2 class="font-semibold text-gray-900 group-hover:text-emerald-900">
              {{ section.title }}
            </h2>
            <p class="mt-2 flex-1 text-sm leading-relaxed text-gray-600">
              {{ section.description }}
            </p>
            <span
              class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-emerald-700 group-hover:text-emerald-900"
            >
              {{ section.cta }}
              <span
                class="transition group-hover:translate-x-0.5"
                aria-hidden="true"
              >&rarr;</span>
            </span>
          </Link>
        </div>
      </section>

      <p class="text-center text-xs text-gray-500">
        Operating, investing and financing activities roll up into your period statement.
      </p>
    </div>
  </div>
</template>
