<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { index, store } from '@/routes/items';
import { ItemError } from '@/types/item';
import { Flow } from '@/types/flow';
import { Frequency } from '@/types/frequency';
import { ItemType } from '@/types/item-type';

interface Props {
  itemTypes: ItemType[],
  flows: Flow[],
  frequencies: Frequency[],
  errors: ItemError,
}

const props = defineProps<Props>();

const form = useForm({
    item_type_id: null,
    flow: null,
    frequency: null,
    start_date: null,
    number_of_transactions: null,
    description: null,
    company_name: null,
    amount: null,
    reference: null,
});

function toDecimal(itemForm: any) {
    if (itemForm.target.id === 'amount') {
        form.amount = parseFloat(itemForm.target.value).toFixed(2);
    } 
}
</script>

<template>
  <Head title="Item Types" />
  
  <div style="margin-top: 50px; margin-left: 50px;">
    <Link
      :href="index()"
      class="inline-block px-5 py-1.5 hover:text-gray-700 hover:underline"
    >
        Items
    </Link>
  </div>

  <div class="py-12">
    <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 bg-white p-4 shadow-sm sm:rounded-lg sm:p-8 w-1/3">
      <form @submit.prevent="form.submit(store().method, store().url, {preserveState: true, except: ['itemTypes', 'flows', 'frequencies']})">

        <label for="item_type_id" class="mt-10 block text-sm font-medium text-gray-700">Item Type</label>
        <select v-model="form.item_type_id" required class="w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500">
            <option v-for="item_type in props.itemTypes" :id="item_type.id" :value="item_type.id" class="break-words whitespace-normal">
                {{ item_type.name }} - {{ item_type.category.label }}
            </option>
        </select>
        <p class="input-error mt-2" v-if="props.errors.item_type_id">{{ props.errors.item_type_id }}</p>

        <label for="flow" class="mt-10 block text-sm font-medium text-gray-700">Flow</label>
        <select v-model="form.flow" required class="w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500">
            <option v-for="flow in props.flows" :id="flow.id" :value="flow.id" class="break-words whitespace-normal">
                {{ flow.label }}
            </option>
        </select>
        <p class="input-error mt-2" v-if="props.errors.flow">{{ props.errors.flow }}</p>

        <label for="frequency" class="mt-10 block text-sm font-medium text-gray-700">Frequency</label>
        <select v-model="form.frequency" required class="w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500">
            <option v-for="frequency in props.frequencies" :id="frequency.id" :value="frequency.id" class="break-words whitespace-normal">
                {{ frequency.label }}
            </option>
        </select>
        <p class="input-error mt-2" v-if="props.errors.frequency">{{ props.errors.frequency }}</p>

        <label for="start_date" class="mt-10 block text-sm font-medium text-gray-700">Start Date</label>
        <input
            id="start_date"
            type="date"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500"
            v-model="form.start_date"
            required
            autofocus
            autocomplete="start_date"
        />
        <p class="input-error mt-2" v-if="props.errors.start_date">{{ props.errors.start_date }}</p>

        <label for="amount" class="mt-10 block text-sm font-medium text-gray-700">Amount</label>
        <input
            id="amount"
            type="text"
            inputmode="numeric"
            min="0.01"
            max="1000.00"
            step="0.01"
            @blur="toDecimal"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500"
            v-model.number="form.amount"
            required
            autocomplete="amount"
        />
        <p class="input-error mt-2" v-if="props.errors.amount">{{ props.errors.amount }}</p>

        <label for="number_of_transactions" class="mt-10 block text-sm font-medium text-gray-700">Transactions</label>
        <input
            id="number_of_transactions"
            type="number"
            inputmode="numeric"
            min="1"
            max="1000"
            step="1"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500"
            v-model.number="form.number_of_transactions"
            required
            autocomplete="number_of_transactions"
        />
        <p class="input-error mt-2" v-if="props.errors.number_of_transactions">{{ props.errors.number_of_transactions }}</p>

        <label for="company_name" class="mt-10 block text-sm font-medium text-gray-700">Company Name</label>
        <input
            id="company_name"
            type="text"
            maxlength="255"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500"
            v-model="form.company_name"
            required
            autofocus
            autocomplete="company_name"
        />
        <p class="input-error mt-2" v-if="props.errors.company_name">{{ props.errors.company_name }}</p>

        <label for="company_name" class="mt-10 block text-sm font-medium text-gray-700">Reference</label>
        <input
            id="reference"
            type="text"
            maxlength="255"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500"
            v-model="form.reference"
            autofocus
            autocomplete="reference"
        />
        <p class="input-error mt-2" v-if="props.errors.reference">{{ props.errors.reference }}</p>

        <label for="description" class="mt-10 block text-sm font-medium text-gray-700">Description</label>
        <textarea
            id="description"
            type="text"
            maxlength="2000"
            class="mt-1 min-h-60 w-full rounded-md border border-gray-300"
            v-model="form.description"
            required
            autocomplete="description"
        />
        <p class="input-error mt-2" v-if="props.errors.description">{{ props.errors.description }}</p>

        <div class="mt-4 flex items-center justify-end">
            <button type="submit">Create</button>
        </div>

      </form>
    </div>
  </div>
</template>