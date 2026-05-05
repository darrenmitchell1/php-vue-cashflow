<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { home } from "@/routes/index";
import { create, edit } from '@/routes/items';
import { Item } from '@/types/item';

interface Props {
    items: Item[],
}

const props = defineProps<Props>();
</script>

<template>
  <Head title="Items" />
  
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
        Create an Item
    </Link>
  </div>

  <table style="width: 80%; margin: 0 auto; word-wrap: break-word;">
    <thead>
      <tr style="text-align: center; padding: 30px 20px; text-transform: uppercase; background-color: rgb(143,188,143);">
        <th>Type</th>
        <th>Flow</th>
        <th>Frequency</th>
        <th>Start Date</th>
        <th>Transactions</th>
        <th>Description</th>
        <th>Campany</th>
        <th>Amount $</th>
        <th>Reference</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in props.items" :key="item.id" style="text-align: center; padding: 24px;">
        <td> <span v-if="item.item_type">{{ item.item_type.name }}</span> </td>
        <td>{{ item.flow.label }}</td>
        <td>{{ item.frequency.label }}</td>
        <td>{{ new Date(item.start_date).toLocaleDateString('en-AU') }}</td>
        <td>{{ item.number_of_transactions }}</td>
        <td>{{ item.description }}</td>
        <td>{{ item.company_name }}</td>
        <td>{{ parseFloat(item.amount).toFixed(2) }}</td>
        <td>{{ item.reference }}</td>
        <td>
          <Link
              :href="edit({item: item.id})"
              class="inline-block px-5 py-1.5 hover:text-gray-700 hover:underline"
          >
              Edit
          </Link>
        </td>
      </tr>
    </tbody>
  </table>
</template>