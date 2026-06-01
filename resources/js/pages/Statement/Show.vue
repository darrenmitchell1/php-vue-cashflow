<script setup lang="ts">
import { computed } from 'vue';
import { Statement } from '@/types/statement';

interface StatementResponse {
  statement: Statement;
}

interface CategoryBlock {
  category: { id: string; label: string };
  category_in_period_amount: number;
  category_out_period_amount: number;
  itemTypes?: Record<
    string,
    {
      itemType: { code: string; name: string };
      item_type_in_period_amount: number;
      item_type_out_period_amount: number;
    }
  >;
}

const props = defineProps<{
  statement: StatementResponse;
}>();

const CATEGORY_ORDER = ['operating', 'investing', 'financing'] as const;

const data = computed(() => props.statement.statement);

const categories = computed(() => {
  const blocks = data.value.item_categories as Record<string, CategoryBlock>;
  return CATEGORY_ORDER.map((key) => blocks[key]).filter(Boolean);
});

const preparedDate = computed(() =>
  new Date().toLocaleDateString('en-AU', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  }),
);

function formatDate(iso: string): string {
  return new Date(iso).toLocaleDateString('en-AU', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
  });
}

function formatMoney(value: number): string {
  const amount = Number(value);
  return new Intl.NumberFormat('en-AU', {
    style: 'currency',
    currency: 'AUD',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(Number.isFinite(amount) ? amount : 0);
}

function netAmount(inAmount: number, outAmount: number): number {
  return Number(inAmount) - Number(outAmount);
}

function itemTypeRows(category: CategoryBlock) {
  if (!category.itemTypes) {
    return [];
  }
  return Object.values(category.itemTypes);
}

const openingCash = computed(() =>
  netAmount(data.value.opening_in_balance_amount, data.value.opening_out_balance_amount),
);

const closingCash = computed(() =>
  netAmount(data.value.closing_in_balance_amount, data.value.closing_out_balance_amount),
);

const netChangeInCash = computed(() => closingCash.value - openingCash.value);

const totalNetFromActivities = computed(() =>
  categories.value.reduce(
    (sum, category) =>
      sum + netAmount(category.category_in_period_amount, category.category_out_period_amount),
    0,
  ),
);
</script>

<template>
  <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
  <header class="border-b border-emerald-800/20 bg-emerald-700 px-6 py-8 text-white sm:px-8">
      <p class="text-xs font-semibold tracking-[0.2em] text-emerald-100 uppercase">
        Cash flow statement
      </p>
      <h2 class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl">
        Statement of cash flows
      </h2>
      <dl class="mt-6 grid gap-4 text-sm sm:grid-cols-2">
        <div>
          <dt class="text-emerald-100">Reporting period</dt>
          <dd class="mt-1 font-medium">
            {{ formatDate(data.period_from) }}
            <span class="text-emerald-200">to</span>
            {{ formatDate(data.period_to) }}
          </dd>
        </div>
        <div>
          <dt class="text-emerald-100">Prepared on</dt>
          <dd class="mt-1 font-medium">{{ preparedDate }}</dd>
        </div>
      </dl>
    </header>

    <section class="border-b border-gray-200 bg-gray-50 px-6 py-5 sm:px-8">
      <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-md border border-gray-200 bg-white px-4 py-3 shadow-xs">
          <p class="text-xs font-medium tracking-wide text-gray-500 uppercase">
            Cash at beginning
          </p>
          <p class="mt-1 text-xl font-semibold tabular-nums text-gray-900">
            {{ formatMoney(openingCash) }}
          </p>
        </div>
        <div class="rounded-md border border-gray-200 bg-white px-4 py-3 shadow-xs">
          <p class="text-xs font-medium tracking-wide text-gray-500 uppercase">
            Net change in period
          </p>
          <p
            class="mt-1 text-xl font-semibold tabular-nums"
            :class="netChangeInCash >= 0 ? 'text-emerald-700' : 'text-red-700'"
          >
            {{ formatMoney(netChangeInCash) }}
          </p>
        </div>
        <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 shadow-xs">
          <p class="text-xs font-medium tracking-wide text-emerald-800 uppercase">
            Cash at end
          </p>
          <p class="mt-1 text-xl font-semibold text-emerald-900 tabular-nums">
            {{ formatMoney(closingCash) }}
          </p>
        </div>
      </div>
    </section>

    <div class="divide-y divide-gray-200">
      <section
        v-for="category in categories"
        :key="category.category.id"
        class="px-6 py-6 sm:px-8"
      >
        <h3 class="text-sm font-semibold tracking-wide text-gray-900 uppercase">
          {{ category.category.label }} activities
        </h3>

        <div class="mt-4 overflow-x-auto rounded-md border border-gray-200">
          <table class="min-w-full text-sm">
            <thead>
              <tr class="border-b border-gray-200 bg-emerald-50/80">
                <th
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-emerald-900 uppercase"
                >
                  Line item
                </th>
                <th
                  scope="col"
                  class="px-4 py-3 text-right text-xs font-semibold tracking-wide text-emerald-900 uppercase"
                >
                  Amount
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
              <tr
                v-for="row in itemTypeRows(category)"
                :key="row.itemType.code"
                class="hover:bg-gray-50/80"
              >
                <td class="px-4 py-3 text-gray-800">
                  {{ row.itemType.name }}
                </td>
                <td class="px-4 py-3 text-right font-medium text-gray-900 tabular-nums">
                  {{
                    formatMoney(
                      netAmount(row.item_type_in_period_amount, row.item_type_out_period_amount),
                    )
                  }}
                </td>
              </tr>
              <tr v-if="itemTypeRows(category).length === 0">
                <td colspan="2" class="px-4 py-3 text-gray-500 italic">
                  No activity in this category for the selected period.
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr class="border-t-2 border-emerald-200 bg-emerald-50/50">
                <td class="px-4 py-3 font-semibold text-gray-900">
                  Net cash from {{ category.category.label.toLowerCase() }} activities
                </td>
                <td class="px-4 py-3 text-right font-semibold text-gray-900 tabular-nums">
                  {{
                    formatMoney(
                      netAmount(
                        category.category_in_period_amount,
                        category.category_out_period_amount,
                      ),
                    )
                  }}
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </section>
    </div>

    <footer class="border-t border-gray-200 bg-gray-50 px-6 py-5 sm:px-8">
      <table class="w-full text-sm">
        <tbody class="divide-y divide-gray-200">
          <tr>
            <td class="py-2 font-medium text-gray-700">
              Net cash from operating, investing and financing activities
            </td>
            <td class="py-2 text-right font-medium text-gray-900 tabular-nums">
              {{ formatMoney(totalNetFromActivities) }}
            </td>
          </tr>
          <tr>
            <td class="py-2 text-gray-700">Cash at beginning of period</td>
            <td class="py-2 text-right text-gray-900 tabular-nums">
              {{ formatMoney(openingCash) }}
            </td>
          </tr>
          <tr class="border-t-2 border-gray-300">
            <td class="py-3 font-semibold text-gray-900">Cash at end of period</td>
            <td class="py-3 text-right text-lg font-semibold text-emerald-800 tabular-nums">
              {{ formatMoney(closingCash) }}
            </td>
          </tr>
        </tbody>
      </table>
    </footer>
  </article>
</template>
