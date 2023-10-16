<template>
    <Head title="Transaksi Iuran" />

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
                        <li class="text-neutral-500 dark:text-neutral-400">Iuran Siswa</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 md:mb-0 md:m-2 w-full">
                        <div class="p-6 text-gray-900">
                            <div class="flex flex-col">
                                <div class="row">
                                    <div class="col-md-3">
                                        <Link href="/transaksi/spp/create" type="button" class="btn btn-outline-dark rounded-0 w-full py-2">Tambah Iuran Siswa</Link>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="search" v-model="search" placeholder="Cari data" autofocus>
                                    </div>
                                </div>
                                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                        <div class="overflow-hidden">
                                            <table class="table table-sm min-w-full text-left text-sm font-light">
                                            <thead class="border-b font-medium dark:border-neutral-500">
                                                <tr>
                                                <th scope="col" class="px-6 py-4">Nomor</th>
                                                <th scope="col" class="px-6 py-4">Tanggal</th>
                                                <th scope="col" class="px-6 py-4">Siswa</th>
                                                <th scope="col" class="px-6 py-4">Iuran</th>
                                                <th scope="col" class="px-6 py-4 text-right">Jumlah</th>
                                                <th scope="col" class="px-6 py-4">Rek</th>
                                                <th scope="col" class="px-6 py-4">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="trx in transactions.data" :key="trx" class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-200">
                                                    <td class="whitespace-nowrap px-6 py-2">{{ trx.trn }}</td>
                                                    <td class="whitespace-nowrap px-6 py-2">{{ trx.date }}</td>
                                                    <td class="whitespace-nowrap px-6 py-2">{{ trx.student.nisn }} :: {{ trx.student.fullname }} </td>
                                                    <td class="whitespace-nowrap px-6 py-2"><button data-bs-toggle="modal" :data-bs-target="'#Modal'+ trx.id">{{ trx.due.name }}</button></td>
                                                    <td class="whitespace-nowrap px-6 py-2 text-right">{{ trx.amount.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>
                                                    <td class="whitespace-nowrap px-6 py-2">{{ trx.coa.name }}</td>
                                                    <td class="whitespace-nowrap px-6 py-2">
                                                        <Link :href="`/transaksi/spp/${trx.id}/edit`">Edit</Link> 
                                                        |
                                                        <Link :href="`/transaksi/spp/${trx.id}`" method="delete" onclick="return confirm('Anda yakin??')">Hapus</Link> 
                                                    </td>
                                                    <!-- Modal -->
                                                    <div class="modal fade" :id="'Modal' + trx.id" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="ModalLabel">Keterangan</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            {{ trx.trn }} | {{ trx.description }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-outline-dark rounded-0" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </tr>
                                            </tbody>
                                            </table>
                                            <Pagination :data="transactions"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
        </div>

        <template #footer>
            <h2 class="text-gray-500">Periode : {{ period }}</h2>
        </template>
    </AuthenticatedLayout>
</template>
<script setup>
//import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
//import { Head, Link, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Inertia } from "@inertiajs/inertia";
import { ref, watch } from 'vue';
import { debounce } from 'lodash';
import Pagination from '@/Components/Pagination.vue';


//var curYear = new Date().getFullYear();

const props = defineProps({
    transactions: Object,
    filters: Object,
    period: String,
})

let search = ref(props.filters.search);

const debouncedSearch = debounce(value => {
  Inertia.get(
    "/transaksi/spp/",
    { search: value },
    { preserveState: true }
  );
}, 500); // Waktu tunda 500ms (0.5 detik)

watch(search, debouncedSearch);

</script>