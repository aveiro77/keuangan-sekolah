<template>
    <Head title="Transaksi" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transaksi</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/2">
                <div class="flex flex-col md:flex-row">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 md:mb-0 md:m-2 w-full md:w-1/2">
                        <div class="p-6 text-gray-900">
                            <a href="/transaksi/spp/">Iuran Siswa</a>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 md:mb-0 md:m-2 w-full md:w-1/2">
                        <div class="p-6 text-gray-900">
                            <a href="/transaksi/opr">Operasional Sekolah</a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 md:mb-0 md:m-2 w-full md:w-1/2">
                        <div class="p-6 text-gray-900">
                            <a href="/transaksi/mutasi">Mutasi Rekening</a>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 md:mb-0 md:m-2 w-full md:w-1/2">
                        <div class="p-6 text-gray-900">
                            <a href="/transaksi/pemasukan">Pemasukan</a>
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
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    period: String,
});

</script>