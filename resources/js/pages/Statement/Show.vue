<script setup lang="ts">
import { Statement } from '@/types/statement';

interface Props {
  statement: Statement,
}

const props = defineProps<Props>();
</script>

<template>
  <div class="py-12">
    <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 bg-white p-4 shadow-sm sm:rounded-lg sm:p-8 w-1/3">
      <p>{{ statement.opening_in_balance_amount }}</p>
      <p>{{ statement.opening_out_balance_amount }}</p>
      <p>{{ statement.closing_in_balance_amount }}</p>
      <p>{{ statement.closing_out_balance_amount }}</p>
    </div>
  </div>
</template>