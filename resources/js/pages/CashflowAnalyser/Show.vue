<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { home } from '@/routes/index';

const form = useForm({
  prompt: null as string | null,
});
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
        <form class="space-y-6 px-6 py-6 sm:px-8">
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
        </form>
      </section>

    </div>
  </div>
</template>
