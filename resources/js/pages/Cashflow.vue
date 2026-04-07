<script setup lang="ts">
import {Head, Link} from '@inertiajs/vue3';
import { index as itemTypeIndex  } from "@/routes/item_types/index";
import { index as itemIndex  } from "@/routes/items/index";
import { index as statementIndex  } from "@/routes/statement/index";
</script>

<template>
    <Head title="Cashflow">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]"
    >
        <div
            class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
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
                                :href="itemTypeIndex()"
                                class="inline-block px-5 py-1.5"
                            >
                                Types
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="itemIndex()"
                                class="inline-block px-5 py-1.5"
                            >
                                Item Transactions
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="statementIndex()"
                                class="inline-block px-5 py-1.5"
                            >
                                Statement
                            </Link>
                        </li>
                    </ul>
                </div>
            </main>
        </div>
    </div>
</template>
