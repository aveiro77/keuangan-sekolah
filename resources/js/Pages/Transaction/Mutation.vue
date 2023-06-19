<template>
    <Head title="Transaksi Mutasi Rekening" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <Link href="/transaksi">Transaksi</Link>
                </h2>
                <nav class="ml-4 w-full rounded-md">
                    <ol class="list-reset flex">
                        <li>
                        <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li class="text-neutral-500 dark:text-neutral-400">Mutasi Rekening</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <!---->
                    <div class="p-6 text-gray-900">
                       
                       
                       <div class="row">
                            <div class="col-md-3">
                                <Link href="/transaksi/mutasi/create" type="button" class="btn btn-sm btn-outline-dark rounded-0 py-2 w-full">Tambah Transaksi</Link>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="search" v-model="search" placeholder="Cari data" autofocus>
                            </div>
                        </div>

                       <div class="flex flex-col">
                           <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                               <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                   <div class="overflow-hidden">
                                       <table class="table table-sm min-w-full text-left text-sm font-light">
                                       <thead class="border-b font-medium dark:border-neutral-500">
                                           <tr>
                                           <th scope="col" class="px-6 py-4">Nomor</th>
                                           <th scope="col" class="px-6 py-4">Tanggal</th>
                                           <th scope="col" class="px-6 py-4">Rekening</th>
                                           <th scope="col" class="px-6 py-4">Keterangan</th>
                                           <th scope="col" class="px-6 py-4 text-right">Keluar</th>
                                           <th scope="col" class="px-6 py-4 text-right">Masuk</th>
                                           <th scope="col" class="px-6 py-4 text-center">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           <tr v-for="trx in mutations.data" :key="trx" class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-200">
                                               <td class="whitespace-nowrap px-6 py-2">{{ trx.trn }}</td>
                                               <td class="whitespace-nowrap px-6 py-2">{{ trx.date }}</td>
                                               <td class="whitespace-nowrap px-6 py-2">{{ trx.coa.name }}</td>
                                               <td class="whitespace-nowrap px-6 py-2">{{ trx.description }}</td>
                                               <td class="whitespace-nowrap px-6 py-2 text-right">{{ trx.credit.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>
                                               <td class="whitespace-nowrap px-6 py-2 text-right">{{ trx.debit.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>
                                               <td class="whitespace-nowrap px-6 py-2 text-center">
                                                    <template v-if="trx.stack === 1">
                                                        <a :href="`/transaksi/mutasi/${trx.id}/edit`">Edit</a> |
                                                        <Link :href="`/transaksi/mutasi/${trx.trn}`" method="delete" onclick="return confirm('Anda yakin??')">Hapus</Link> 
                                                    </template>
                                                </td>
                                           </tr>
                                       </tbody>
                                       </table>
                                       <Pagination :data="mutations"/>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                    <!---->

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Inertia } from "@inertiajs/inertia";
import { ref, watch } from 'vue';
import { debounce } from 'lodash';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    mutations: Object,
    filters: Object,
})

let search = ref(props.filters.search);

const debouncedSearch = debounce(value => {
  Inertia.get(
    "/transaksi/mutasi/",
    { search: value },
    { preserveState: true }
  );
}, 500); // Waktu tunda 500ms (0.5 detik)

watch(search, debouncedSearch);
</script>