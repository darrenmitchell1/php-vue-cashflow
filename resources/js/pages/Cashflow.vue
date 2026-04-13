<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import ItemTypeController from '@/actions/App/Http/Controllers/ItemTypeController';
import items from "@/routes/items";
import statement from "@/routes/statement";
</script>

<template>
    <Head title="Cashflow" />
    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]"
    >
        <main
            class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg lg:max-w-4xl lg:flex-row"
        >
            <div
                class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
            >
                <h1 class="mb-1 font-medium">Cashflow</h1>
                <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                    Cashflow App to create Cashflow Item Transactions for specific pre-defined Types <br />
                    and produce a Cashflow Statement for a Period.
                </p>
                <ul class="flex gap-3 text-sm leading-normal">
                    <li>
                        <Link
                            :href="ItemTypeController.index()"
                            class="inline-block px-5 py-1.5 hover:text-gray-700 hover:underline"
                        >
                            Types
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="items.index()"
                            class="inline-block px-5 py-1.5 hover:text-gray-700 hover:underline"
                        >
                            Items
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="statement.index()"
                            class="inline-block px-5 py-1.5 hover:text-gray-700 hover:underline"
                        >
                            Statement
                        </Link>
                    </li>
                </ul>
            </div>
        </main>
    </div>
</template>
