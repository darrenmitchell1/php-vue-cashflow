<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { home } from "@/routes/index";
import { create } from '@/routes/item_types';
import { ItemType } from '@/types/item-type';

interface Props {
    itemTypes: ItemType[],
}

const props = defineProps<Props>();
</script>

<template>
  <Head title="Item Types" />
  
  <div style="margin-top: 50px; margin-bottom: 50px; margin-left: 50px;">
    <Link
      :href="home()"
      class="inline-block px-5 py-1.5 hover:text-gray-700 hover:underline"
    >
        Cashflow
    </Link>
    <Link
        :href="create()"
        class="inline-block px-5 py-1.5 hover:text-gray-700 hover:underline"
    >
        Create
    </Link>
  </div>

  <table style="width: 100%; word-wrap: break-word;">
    <thead>
      <tr style="text-align: center; padding: 30px 20px; text-transform: uppercase; background-color: rgb(143,188,143);">
        <th>Code</th>
        <th>Name</th>
        <th>Description</th>
        <th>Category</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="itemType in props.itemTypes" :key="itemType.id" style="text-align: center; padding: 24px;">
        <td>{{ itemType.code }}</td>
        <td>{{ itemType.name }}</td>
        <td>{{ itemType.description }}</td>
        <td>{{ itemType.category.label }}</td>
      </tr>
    </tbody>
  </table>
</template>