<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { StatementError } from '@/types/statement';
import { home } from "@/routes/index";
import { show } from '@/routes/statement';
import Show from './Show.vue';

interface Props {
  errors: StatementError,
}

const props = defineProps<Props>();

const form = useForm({
    period_from: null,
    period_to: null,
});

const statement = ref(null);
const errorMessage = ref(null);

async function getStatement() {
  const route = show({
    query: {
      period_from: form.period_from,
      period_to: form.period_to,
    }
  });

  try {
    const response = await fetch(route.url);
    
    // Check for HTTP errors (status outside 200-299)
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status} - ${response.text}`);
    }

    statement.value = await response.json();
  } catch (error) {
    // Catch network errors and manual errors thrown above
    errorMessage.value = error.message;
    console.error("Fetch failed:", error.message);
  }
}
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


  <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 bg-white p-4 shadow-sm sm:rounded-lg sm:p-8 w-1/3">
    <form class="flex items-center" @submit.prevent="getStatement">

      <label for="period_from" class="mr-4 block text-sm font-medium text-gray-700">From</label>
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

      <label for="period_to" class="ml-10 mr-4 block text-sm font-medium text-gray-700">To</label>
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

      <div class="ml-10 mt-2">
          <button type="submit">Show Statement</button>
      </div>

    </form>
  </div>

  <div v-if="statement" class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 bg-white p-4 shadow-sm sm:rounded-lg sm:p-8">
      <Show :statement="statement" />
  </div>
</template>