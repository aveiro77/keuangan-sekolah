<template>
    <Head title="Dashboard" />
  
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
      </template>
  
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-info bg-opacity-10 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <div class="flex">
                            <div class="w-1/3 border-r dark:border-gray-400 text-center">
                                <!-- Konten bagian pertama -->
                                Total Pemasukan :<br>Rp. {{ (due+income).toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}
                            </div>
                            <div class="w-1/3 border-r dark:border-gray-400 text-center">
                                <!-- Konten bagian kedua -->
                                Bulan ini :<br>Rp. {{ (dueToDate+incomeToDate).toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}
                            </div>
                            <div class="w-1/3 text-center">
                                <!-- Konten bagian ketiga -->
                                Hari ini :<br>Rp. {{ (dueToDay+incomeToDay).toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-warning bg-opacity-10 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <div class="flex">
                            <div class="w-1/3 border-r dark:border-gray-400 text-center">
                                <!-- Konten bagian pertama -->
                                Total Pengeluaran :<br>Rp. {{ outcome.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}
                            </div>
                            <div class="w-1/3 border-r dark:border-gray-400 text-center">
                                <!-- Konten bagian kedua -->
                                Bulan ini :<br>Rp. {{ outcomeToDate.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}
                            </div>
                            <div class="w-1/3 text-center">
                                <!-- Konten bagian ketiga -->
                                Hari ini :<br>Rp. {{ outcomeToDay.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}
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
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
defineProps({
    due: Number,
    income: Number,
    dueToDate: Number,
    incomeToDate: Number,
    dueToDay: Number,
    incomeToDay: Number,
    outcome: Number,
    outcomeToDate: Number,
    outcomeToDay: Number,
    period: String,
})
</script>

<!-- OLD
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
-->