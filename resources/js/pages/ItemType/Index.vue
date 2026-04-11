<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { home } from "@/routes/index";
import { create } from '@/routes/item_types';

const props = defineProps({
    itemTypes: {
        type: JSON,
        required: true,
    },
});
</script>

<template>
  <Head title="Item Types" />
  <Link
      :href="home()"
      class="inline-block px-5 py-1.5"
  >
      Cashflow
  </Link>
  <Link
      :href="create()"
      class="inline-block px-5 py-1.5"
  >
      Create
  </Link>
  <table>
    <thead>
      <tr>
        <th>Name</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="itemType in itemTypes" :key="itemType.id">
        <td>{{ itemType.name }}</td>
      </tr>
    </tbody>
  </table>
</template>