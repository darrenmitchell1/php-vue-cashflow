<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { index, update } from '@/routes/items';
import { Item, ItemError } from '@/types/item';
import { Flow } from '@/types/flow';
import { Frequency } from '@/types/frequency';
import { ItemType } from '@/types/item-type';
import { toEndDate } from '@/lib/date-formatters';

interface Props {
  item: Item;
  itemTypes: ItemType[];
  flows: Flow[];
  frequencies: Frequency[];
  errors: ItemError;
}

const props = defineProps<Props>();

const updateRoute = update({ item: props.item.id });

const form = useForm({
  item_type_id: props.item.item_type?.id ?? null,
  flow: props.item.flow.id,
  frequency: props.item.frequency.id,
  start_date: new Date(props.item.start_date).toISOString().split('T')[0],
  number_of_transactions: Number(props.item.number_of_transactions),
  description: props.item.description,
  company_name: props.item.company_name,
  amount: props.item.amount,
  reference: props.item.reference,
});

const inputClass =
  'mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-xs focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none';

const selectClass =
  'mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-xs focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none';

function toDecimal(): void {
  if (form.amount != null) {
    form.amount = Number(Number(form.amount).toFixed(2));
  }
}

const itemEndDte = ref('');

function setEndDate() : void {
  if (form.start_date != null && form.frequency != null && form.number_of_transactions != null) {
    itemEndDte.value = toEndDate(new Date(form.start_date), form.frequency, form.number_of_transactions).toISOString().split('T')[0];
  }
}

setEndDate();
</script>

<template>
  <Head title="Edit item" />

  <div class="min-h-screen bg-gray-50 py-8 text-gray-900">
    <div class="mx-auto max-w-3xl space-y-8 px-4 sm:px-6 lg:px-8">
      <nav>
        <Link
          :href="index()"
          class="inline-flex items-center gap-1 text-sm font-medium text-emerald-800 hover:text-emerald-950 hover:underline"
        >
          <span aria-hidden="true">&larr;</span>
          Back to items
        </Link>
      </nav>

      <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <header class="border-b border-emerald-800/20 bg-emerald-700 px-6 py-6 text-white sm:px-8">
          <p class="text-xs font-semibold tracking-[0.2em] text-emerald-100 uppercase">
            Cashflow
          </p>
          <h1 class="mt-2 text-2xl font-semibold tracking-tight">Edit item</h1>
          <p class="mt-2 max-w-xl text-sm text-emerald-100">
            Update this cashflow item and its generated transactions.
          </p>
        </header>

        <form
          class="space-y-8 px-6 py-6 sm:px-8"
          @submit.prevent="form.submit(updateRoute.method, updateRoute.url)"
        >
          <fieldset class="space-y-5">
            <legend class="text-sm font-semibold text-gray-900">Classification</legend>

            <div>
              <label for="item_type_id" class="block text-sm font-medium text-gray-700">
                Item type
              </label>
              <select
                id="item_type_id"
                v-model="form.item_type_id"
                required
                :class="selectClass"
              >
                <option
                  v-for="itemType in props.itemTypes"
                  :key="itemType.id"
                  :value="itemType.id"
                >
                  {{ itemType.name }} — {{ itemType.category.label }}
                </option>
              </select>
              <p v-if="props.errors.item_type_id" class="mt-2 text-sm text-red-600">
                {{ props.errors.item_type_id }}
              </p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
              <div>
                <label for="flow" class="block text-sm font-medium text-gray-700">Flow</label>
                <select id="flow" v-model="form.flow" required :class="selectClass">
                  <option v-for="flow in props.flows" :key="flow.id" :value="flow.id">
                    {{ flow.label }}
                  </option>
                </select>
                <p v-if="props.errors.flow" class="mt-2 text-sm text-red-600">
                  {{ props.errors.flow }}
                </p>
              </div>

              <div>
                <label for="frequency" class="block text-sm font-medium text-gray-700">
                  Frequency
                </label>
                <select id="frequency" v-model="form.frequency" required :class="selectClass" @blur="setEndDate()">
                  <option
                    v-for="frequency in props.frequencies"
                    :key="frequency.id"
                    :value="frequency.id"
                  >
                    {{ frequency.label }}
                  </option>
                </select>
                <p v-if="props.errors.frequency" class="mt-2 text-sm text-red-600">
                  {{ props.errors.frequency }}
                </p>
              </div>
            </div>
          </fieldset>

          <fieldset class="space-y-5 border-t border-gray-100 pt-8">
            <legend class="text-sm font-semibold text-gray-900">Schedule &amp; amount</legend>

            <div class="grid gap-5 sm:grid-cols-2">
              <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">
                  Start date
                </label>
                <input
                  id="start_date"
                  v-model="form.start_date"
                  type="date"
                  required
                  autofocus
                  autocomplete="start_date"
                  :class="inputClass"
                  @blur="setEndDate()"
                />
                <p v-if="props.errors.start_date" class="mt-2 text-sm text-red-600">
                  {{ props.errors.start_date }}
                </p>
              </div>

              <div>
                <label
                  for="number_of_transactions"
                  class="block text-sm font-medium text-gray-700"
                >
                  Number of transactions
                </label>
                <input
                  id="number_of_transactions"
                  v-model.number="form.number_of_transactions"
                  type="number"
                  inputmode="numeric"
                  min="1"
                  max="1000"
                  step="1"
                  required
                  autocomplete="number_of_transactions"
                  :class="inputClass"
                  @blur="setEndDate()"
                />
                <p v-if="props.errors.number_of_transactions" class="mt-2 text-sm text-red-600">
                  {{ props.errors.number_of_transactions }}
                </p>
                <p class="text-sm font-medium text-gray-700">
                  {{ itemEndDte }}
                </p>
              </div>
            </div>

            <div class="sm:w-1/2">
              <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
              <input
                id="amount"
                v-model.number="form.amount"
                type="text"
                inputmode="decimal"
                min="0.01"
                max="1000"
                step="0.01"
                required
                autocomplete="amount"
                :class="inputClass"
                @blur="toDecimal"
              />
              <p v-if="props.errors.amount" class="mt-2 text-sm text-red-600">
                {{ props.errors.amount }}
              </p>
            </div>
          </fieldset>

          <fieldset class="space-y-5 border-t border-gray-100 pt-8">
            <legend class="text-sm font-semibold text-gray-900">Details</legend>

            <div>
              <label for="company_name" class="block text-sm font-medium text-gray-700">
                Company name
              </label>
              <input
                id="company_name"
                v-model="form.company_name"
                type="text"
                maxlength="255"
                required
                autocomplete="organization"
                :class="inputClass"
              />
              <p v-if="props.errors.company_name" class="mt-2 text-sm text-red-600">
                {{ props.errors.company_name }}
              </p>
            </div>

            <div>
              <label for="reference" class="block text-sm font-medium text-gray-700">
                Reference
                <span class="font-normal text-gray-500">(optional)</span>
              </label>
              <input
                id="reference"
                v-model="form.reference"
                type="text"
                maxlength="255"
                autocomplete="off"
                :class="inputClass"
              />
              <p v-if="props.errors.reference" class="mt-2 text-sm text-red-600">
                {{ props.errors.reference }}
              </p>
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
              <span v-if="form.processing">Saving…</span>
              <span v-else>Save changes</span>
            </button>
          </div>
        </form>
      </section>
    </div>
  </div>
</template>
