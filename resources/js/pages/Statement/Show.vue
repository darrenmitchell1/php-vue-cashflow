<script setup lang="ts">
import { Statement } from '@/types/statement';

interface Props {
  statement: Statement,
}

const props = defineProps<Props>();

const today = Date.now()
</script>

<template>
  <div>
    <p>Cashflow Statement</p>
    <p>Date: {{ today.toLocaleString }}</p>
    <p>For time period: {{ props.statement.period_from }} to {{ props.statement.period_to }}</p>
    <p>Cash at beginning of period: {{ props.statement.opening_in_balance_amount - props.statement.opening_out_balance_amount }}</p>
    <p>Cash at end of period: {{ props.statement.closing_in_balance_amount - props.statement.closing_out_balance_amount }}</p>
  </div>
  <div class="py-12">
    <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 bg-white p-4 shadow-sm sm:rounded-lg sm:p-8 w-1/3">
      <div v-for="(category, catIdx) in props.statement.item_categories" :key="catIdx" style="width: 100%; padding: 24px;">
        <h2>catIdx</h2>
        <table style="width: 100%; word-wrap: break-word;">
          <thead>
            <tr style="text-align: center; padding: 30px 20px; text-transform: uppercase; background-color: rgb(143,188,143);">
              <th>Item</th>
              <th>Amount $</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in category" :key="item.id" style="text-align: center; padding: 24px;">
              <td>{{ item.item_type.name }}</td>
              <td>{{ parseFloat(item.item_period_amount).toFixed(2) }}</td>
            </tr>
          </tbody>
        </table>
        <div>
          <p>NET CASH FLOW FROM {{ catIdx }} : netCashFlowAmount</p>
        </div>
      </div>
    </div>
  </div>
</template>