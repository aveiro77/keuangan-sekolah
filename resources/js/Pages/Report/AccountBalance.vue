<template>
    <Head title="Laporan" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <Link href="/laporan"> Laporan</Link>
                </h2>
                <nav class="ml-4 w-full rounded-md">
                    <ol class="list-reset flex">
                        <li>
                        <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li class="text-neutral-500 dark:text-neutral-400">Saldo Rekening</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900" >
                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        <table class="table table-sm min-w-full text-left text-sm font-light">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr>
                                            <th scope="col" class="px-6 py-4">Rek</th>
                                            <th scope="col" class="px-6 py-4">Nama</th>
                                            <th scope="col" class="px-6 py-4 text-right">Awal</th>
                                            <th scope="col" class="px-6 py-4 text-right" >Jan</th>
                                            <th scope="col" class="px-6 py-4 text-right">Feb</th>
                                            <th scope="col" class="px-6 py-4 text-right" >Mar</th>
                                            <th scope="col" class="px-6 py-4 text-right">Apr</th>
                                            <th scope="col" class="px-6 py-4 text-right" >Mei</th>
                                            <th scope="col" class="px-6 py-4 text-right">Jun</th>
                                            <th scope="col" class="px-6 py-4 text-right">Jul</th>
                                            <th scope="col" class="px-6 py-4 text-right" >Ags</th>
                                            <th scope="col" class="px-6 py-4 text-right">Sep</th>
                                            <th scope="col" class="px-6 py-4 text-right" >Okt</th>
                                            <th scope="col" class="px-6 py-4 text-right">Nov</th>
                                            <th scope="col" class="px-6 py-4 text-right" >Des</th>
                                            <th scope="col" class="px-6 py-4 text-right" >Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="d in data" :key="d" class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-200">
                                                <td class="whitespace-nowrap px-6 py-2">{{ d.code }}</td>
                                                <td class="whitespace-nowrap px-6 py-2">{{ d.name }}</td>
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M00.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M01.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M02.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M03.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M04.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M05.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M06.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M07.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M08.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M09.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M10.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M11.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ d.M12.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
                                                <td class="whitespace-nowrap px-6 py-2 text-right">{{ (d.M00+d.M01+d.M02+d.M03+d.M04+d.M05+d.M06+d.M07+d.M08+d.M09+d.M10+d.M11+d.M12).toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 }).replace(',', '.') }}</td>                                                    
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

defineProps({
    data: Object,
})
</script>