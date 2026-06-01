<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Statement, StatementError } from '@/types/statement';
import { home } from '@/routes/index';
import { show } from '@/routes/statement';
import Show from './Show.vue';

interface Props {
  errors: StatementError;
}

interface StatementResponse {
  statement: Statement;
}

const props = defineProps<Props>();

const form = useForm({
  period_from: null as string | null,
  period_to: null as string | null,
});

const statement = ref<StatementResponse | null>(null);
const errorMessage = ref<string | null>(null);
const loading = ref(false);

async function getStatement() {
  errorMessage.value = null;
  loading.value = true;

  const route = show({
    query: {
      period_from: form.period_from,
      period_to: form.period_to,
    },
  });

  try {
    const response = await fetch(route.url);

    if (!response.ok) {
      throw new Error(`Could not load statement (HTTP ${response.status}).`);
    }

    statement.value = await response.json();
  } catch (error) {
    statement.value = null;
    errorMessage.value = error instanceof Error ? error.message : 'Something went wrong.';
    console.error('Fetch failed:', error);
  } finally {
    loading.value = false;
  }
}
</script>

<template>
  <Head title="Cashflow Statement" />

  <div class="min-h-screen bg-gray-50 py-8 text-gray-900">
    <div class="mx-auto max-w-4xl space-y-8 px-4 sm:px-6 lg:px-8">
      <nav>
        <Link
          :href="home()"
          class="inline-flex items-center gap-1 text-sm font-medium text-emerald-800 hover:text-emerald-950 hover:underline"
        >
          <span aria-hidden="true">&larr;</span>
          Back to Cashflow
        </Link>
      </nav>

      <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <header class="border-b border-emerald-800/20 bg-emerald-700 px-6 py-6 text-white sm:px-8">
          <p class="text-xs font-semibold tracking-[0.2em] text-emerald-100 uppercase">
            Reports
          </p>
          <h1 class="mt-2 text-2xl font-semibold tracking-tight">Cashflow statement</h1>
          <p class="mt-2 max-w-xl text-sm text-emerald-100">
            Choose a reporting period to generate your statement of cash flows.
          </p>
        </header>

        <form class="space-y-6 px-6 py-6 sm:px-8" @submit.prevent="getStatement">
          <div class="grid gap-6 sm:grid-cols-2">
            <div>
              <label for="period_from" class="block text-sm font-medium text-gray-700">
                Period from
              </label>
              <input
                id="period_from"
                v-model="form.period_from"
                type="date"
                required
                autofocus
                autocomplete="period_from"
                class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-xs focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none"
              />
              <p v-if="props.errors.period_from" class="mt-2 text-sm text-red-600">
                {{ props.errors.period_from }}
              </p>
            </div>

            <div>
              <label for="period_to" class="block text-sm font-medium text-gray-700">
                Period to
              </label>
              <input
                id="period_to"
                v-model="form.period_to"
                type="date"
                required
                autocomplete="period_to"
                class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-xs focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none"
              />
              <p v-if="props.errors.period_to" class="mt-2 text-sm text-red-600">
                {{ props.errors.period_to }}
              </p>
            </div>
          </div>

          <div
            v-if="errorMessage"
            class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"
            role="alert"
          >
            {{ errorMessage }}
          </div>

          <div class="flex flex-wrap items-center gap-3 border-t border-gray-100 pt-4">
            <button
              type="submit"
              :disabled="loading"
              class="inline-flex items-center justify-center rounded-md bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white shadow-xs transition hover:bg-emerald-800 focus:ring-2 focus:ring-emerald-500/40 focus:outline-none disabled:cursor-not-allowed disabled:opacity-60"
            >
              <span v-if="loading">Generating…</span>
              <span v-else>Show statement</span>
            </button>
            <p v-if="statement && !loading" class="text-sm text-gray-500">
              Statement generated for the selected period.
            </p>
          </div>
        </form>
      </section>

      <Show v-if="statement" :statement="statement" />
    </div>
  </div>
</template>
