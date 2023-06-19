<template>
    <Head title="Rekening" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <Link href="/master"> Master</Link>
                </h2>
                <nav class="ml-4 w-full rounded-md">
                    <ol class="list-reset flex">
                        <li>
                        <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li class="text-neutral-500 dark:text-neutral-400">Rekening</li>
                    </ol>
                </nav>
            </div>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!--PLace content here-->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                       
                        <Link href="/master/rekening/create" type="button" class="btn btn-sm btn-outline-dark rounded-0">Tambah Rekening</Link>

                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        <table class="table table-sm min-w-full text-left text-sm font-light">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr>
                                            <th scope="col" class="px-6 py-4">#</th>
                                            <th scope="col" class="px-6 py-4">Kode</th>
                                            <th scope="col" class="px-6 py-4">Nama</th>
                                            <th scope="col" class="px-6 py-4 text-right">Saldo Awal</th>
                                            <th scope="col" class="px-6 py-4 text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="coa in coas" :key="coa" class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-200">
                                                <td class="whitespace-nowrap px-6 py-2 font-medium">{{ coa.year }}</td>
                                                <td class="whitespace-nowrap px-6 py-2">{{ coa.code }}</td>
                                                <td class="whitespace-nowrap px-6 py-2">{{ coa.name }}</td>
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ coa.initial_balance.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>
                                                <td class="whitespace-nowrap px-6 py-2 text-center">
                                                    <Link :href="`/master/rekening/${coa.id}/edit`">Edit</Link> 
                                                    |
                                                    <Link :href="`/master/rekening/${coa.id}`" method="delete" onclick="return confirm('Anda yakin??')">Hapus</Link> 
                                                </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end content-->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { isIntegerKey } from '@vue/shared';

defineProps({
    coas: Object,
})

let nomor = 1 ;
</script>