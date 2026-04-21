<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { StatementError } from '@/types/statement';
import { home } from "@/routes/index";

interface Props {
  errors: StatementError,
}

const props = defineProps<Props>();

const form = useForm({
    period_from: null,
    period_to: null,
});
</script>
<template>
  <Head title="Cashflow Statement" />
  
  <div style="margin-top: 50px; margin-left: 50px;">
    <Link
      :href="home()"
      class="inline-block px-5 py-1.5 hover:text-gray-700 hover:underline"
    >
        Cashflow
    </Link>
  </div>

  <div class="py-12">
    <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 bg-white p-4 shadow-sm sm:rounded-lg sm:p-8 w-1/3">
      <form>

        <label for="period_from" class="mt-10 block text-sm font-medium text-gray-700">From</label>
        <input
            id="period_from"
            type="date"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500"
            v-model="form.period_from"
            required
            autofocus
            autocomplete="period_from"
        />
        <p class="input-error mt-2" v-if="props.errors.period_from">{{ props.errors.period_from }}</p>

        <label for="period_to" class="mt-10 block text-sm font-medium text-gray-700">To</label>
        <input
            id="period_to"
            type="date"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500"
            v-model="form.period_to"
            required
            autofocus
            autocomplete="period_to"
        />
        <p class="input-error mt-2" v-if="props.errors.period_to">{{ props.errors.period_to }}</p>

        <div class="mt-4 flex items-center justify-end">
            <button type="submit">Show Statement</button>
        </div>

      </form>
    </div>
  </div>
</template>