<script setup lang="ts">
import { Statement } from '@/types/statement';

interface Props {
  statement: Statement|never,
}

const props = defineProps<Props>();

const today = Date.now()
</script>

<template>
  <div>
    <p>Cashflow Statement</p>
    <p>Date: {{ new Date().toLocaleDateString('en-AU') }}</p>
    <p>For time period: {{ new Date(props.statement.statement.period_from).toLocaleDateString('en-AU') }} to {{ new Date(props.statement.statement.period_to).toLocaleDateString('en-AU') }}</p>
    <p>Cash at beginning of period: {{ parseFloat(props.statement.statement.opening_in_balance_amount - props.statement.statement.opening_out_balance_amount).toFixed(2) }}</p>
    <p>Cash at end of period: {{ parseFloat(props.statement.statement.closing_in_balance_amount - props.statement.statement.closing_out_balance_amount).toFixed(2) }}</p>
  </div>
  
  <div style="width: 100%;" class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 bg-white p-4 shadow-sm sm:rounded-lg sm:p-8 w-1/3">
    <div v-for="(category, catIdx) in props.statement.statement.item_categories" :key="catIdx" style="width: 100%; padding: 24px;">
      <h2> {{ category.category.label }}  catIdx</h2>
      <table style="width: 100%; word-wrap: break-word;">
        <thead>
          <tr style="text-align: center; padding: 30px 20px; text-transform: uppercase; background-color: rgb(143,188,143);">
            <th>Item</th>
            <th>Amount $</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="itemType in category.itemTypes" :key="itemType.id" style="text-align: center; padding: 24px;">
            <td>{{ itemType.itemType.name }}</td>
            <td>{{ parseFloat(itemType.item_type_in_period_amount - itemType.item_type_out_period_amount).toFixed(2) }}</td>
          </tr>
        </tbody>
      </table>
      <div>
        <p>NET CASH FLOW FROM {{ category.category.label }} : {{ parseFloat(category.category_in_period_amount - category.category_out_period_amount).toFixed(2) }}</p>
      </div>
    </div>
  </div>
</template>