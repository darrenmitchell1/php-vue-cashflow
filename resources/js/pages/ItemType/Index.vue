<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { home } from "@/routes/index";
import { create, edit } from '@/routes/item_types';
import { ItemType } from '@/types/item-type';

interface Props {
    itemTypes: ItemType[],
}

const props = defineProps<Props>();
</script>

<template>
  <Head title="Item Types" />
  
  <div style="margin-top: 50px; margin-bottom: 50px; margin-left: 10%;">
    <Link
      :href="home()"
      style="padding-left: 0;"
      class="inline-block px-5 py-1.5 hover:text-gray-700 hover:underline"
    >
        Cashflow
    </Link>
    <Link
        :href="create()"
        class="inline-block px-5 py-1.5 hover:text-gray-700 hover:underline"
    >
        Create an Item Type
    </Link>
  </div>

  <table style="width: 80%; margin: 0 auto; word-wrap: break-word;">
    <thead>
      <tr style="text-align: center; padding: 30px 20px; text-transform: uppercase; background-color: rgb(143,188,143);">
        <th>Code</th>
        <th>Name</th>
        <th>Description</th>
        <th>Category</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="itemType in props.itemTypes" :key="itemType.id" style="text-align: center; padding: 24px;">
        <td>{{ itemType.code }}</td>
        <td>{{ itemType.name }}</td>
        <td>{{ itemType.description }}</td>
        <td>{{ itemType.category.label }}</td>
        <td>
          <Link
              :href="edit({itemType: itemType.id})"
              class="inline-block px-5 py-1.5 hover:text-gray-700 hover:underline"
          >
              Edit
          </Link>
        </td>
      </tr>
    </tbody>
  </table>
</template>