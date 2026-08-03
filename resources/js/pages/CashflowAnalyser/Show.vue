<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { home } from '@/routes/index';
import { prompt } from '@/routes/cashflow-analyser';

const form = useForm({
  prompt: null as string | null,
});

const reply = ref<string | null>(null);

async function getReply() {
  reply.value = 'Thinking ...';

  const route = prompt();

  try {
    const response = await fetch(route.url, {
      method: route.method,
      body: JSON.stringify({'prompt' : form.prompt})
    });

    if (!response.ok) {
      throw new Error(`Could not load reply (HTTP ${response.status}).`);
    }

    reply.value = await response.json();
  } catch (error) {
    reply.value = error instanceof Error ? error.message : 'Something went wrong.';
    console.error('Fetch failed:', error);
  }
}
</script>

<template>
  <Head title="Cashflow Analyser" />

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
            Cashflow
          </p>
          <h1 class="mt-2 text-2xl font-semibold tracking-tight">Analyser</h1>
          <p class="mt-2 max-w-2xl text-sm text-emerald-100">
            Analyse Item Transactions using AI Agent.
          </p>
        </header>

        <form class="space-y-6 px-6 py-6 sm:px-8" @submit.prevent="getReply">
          <div class="flex flex-wrap items-center gap-3 border-t border-gray-100 pt-4">
            <label for="description" class="block form-label">
              Prompt
            </label>
            <textarea
              id="prompt"
              v-model="form.prompt"
              maxlength="2000"
              placeholder="Ask something..." 
              required
              rows="5"
              autocomplete="off"
              class="mt-2 block w-full form-textarea"
            />
          </div>
          <div class="flex flex-wrap items-center">
            <button
              type="submit"
              class="inline-flex items-center justify-center rounded-md bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white shadow-xs transition hover:bg-emerald-800 focus:ring-2 focus:ring-emerald-500/40 focus:outline-none disabled:cursor-not-allowed disabled:opacity-60"
            >
              <span>Submit</span>
            </button>
          </div>
          <p v-if="reply" class="text-sm text-gray-500">
            {{ reply  }}
          </p>
        </form>
      </section>

    </div>
  </div>
</template>
