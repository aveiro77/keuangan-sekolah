<template>
    <Head title="Laporan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/2">
                <div class="flex flex-col md:flex-row">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 md:mb-0 md:m-2 w-full md:w-1/2">
                        <div class="p-6 text-gray-900">
                            <Link :href="`/laporan/saldo-rekening/`">Saldo Rekening</Link> 
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 md:mb-0 md:m-2 w-full md:w-1/2">
                        <div class="p-6 text-gray-900">
                            <a href="/laporan/iuran-spp/">Iuran SPP</a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 md:mb-0 md:m-2 w-full md:w-1/2">
                        <div class="p-6 text-gray-900">
                            <a href="/laporan/iuran-non-spp/">Iuran NON SPP</a>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 md:mb-0 md:m-2 w-full md:w-1/2">
                        <div class="p-6 text-gray-900">
                            <a href="/laporan/pengeluaran/">Pengeluaran</a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 md:mb-0 md:m-2 w-full md:w-1/2">
                        <div class="p-6 text-gray-900">
                            <a href="/laporan/pemasukan/">Pemasukan</a>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 md:mb-0 md:m-2 w-full md:w-1/2">
                        
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>
