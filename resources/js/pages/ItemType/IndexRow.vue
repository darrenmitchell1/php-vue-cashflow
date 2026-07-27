<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { destroy, edit, restore } from '@/routes/item_types';
import type { ItemType } from '@/types/item-type';

interface Props {
  itemType: ItemType;
}

const props = defineProps<Props>();

function categoryBadgeClass(categoryId: string): string {
  switch (categoryId) {
    case 'operating':
      return 'bg-emerald-100 text-emerald-800';
    case 'investing':
      return 'bg-sky-100 text-sky-800';
    case 'financing':
      return 'bg-violet-100 text-violet-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
}

const isDeleted = ref(props.itemType.deleted_at?.length ?? 0 > 0);

const errorMessage = ref<string | null>(null);

async function deleteItemType(uuid: string) {
  errorMessage.value = null;

  const route = destroy(uuid);

  try {
    const response = await fetch(route.url, {method: route.method});

    if (!response.ok) {
      throw new Error(`Could not Delete the Item Type (HTTP ${response.status}).`);
    }

    isDeleted.value = true;
  } catch (error) {
    errorMessage.value = error instanceof Error ? error.message : 'Something went wrong.';
    console.error('Delete for ${uuid} failed:', error);
  }
}

async function restoreItemType(uuid: string) {
  errorMessage.value = null;

  const route = restore(uuid);

  try {
    const response = await fetch(route.url, {method: route.method});

    if (!response.ok) {
      throw new Error(`Could not Restore the Item Type (HTTP ${response.status}).`);
    }

    isDeleted.value = false;
  } catch (error) {
    errorMessage.value = error instanceof Error ? error.message : 'Something went wrong.';
    console.error('Restore for ${uuid} failed:', error);
  }
}
</script>

<template>
  <tr>
    <td class="px-4 py-3 font-mono text-sm font-medium text-gray-900">
      {{ itemType.code }}
    </td>
    <td class="px-4 py-3 font-medium text-gray-900">
      {{ itemType.name }}
    </td>
    <td
      class="max-w-md truncate px-4 py-3 text-gray-700"
      :title="itemType.description"
    >
      {{ itemType.description }}
    </td>
    <td class="px-4 py-3">
      <span
        class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium"
        :class="categoryBadgeClass(itemType.category.id)"
      >
        {{ itemType.category.label }}
      </span>
    </td>
    <td v-if="isDeleted" class="px-4 py-3 text-right">
      <Link
        @click="restoreItemType(itemType.id)"
        class="font-medium text-emerald-700 hover:text-emerald-900 hover:underline"
      >
        Restore
      </Link>
    </td>
    <td v-else class="px-4 py-3 text-right">
      <Link
        :href="edit({ itemType: itemType.id })"
        class="font-medium text-emerald-700 hover:text-emerald-900 hover:underline"
      >
        Edit
      </Link>
      <Link
        @click="deleteItemType(itemType.id)"
        class="font-medium text-emerald-700 hover:text-emerald-900 hover:underline"
      >
        Delete
      </Link>
    </td>
  </tr>
</template>
