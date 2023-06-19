<template>
    <Head title="Siswa" />

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
                        <li class="text-neutral-500 dark:text-neutral-400">Siswa</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!--Place content here-->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <Link href="/master/siswa/create" type="button" class="btn btn-sm btn-outline-dark rounded-0">Tambah Siswa</Link>

                        <div class="flex flex-col">
                            <input type="text" class="form-control col-md-4 w-1/2 mt-4" id="search" v-model="search" placeholder="Cari data" autofocus>
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full text-left text-sm font-light">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr>
                                            <th scope="col" class="px-6 py-4">#</th>
                                            <th scope="col" class="px-6 py-4">NISN</th>
                                            <th scope="col" class="px-6 py-4">Nama</th>
                                            <th scope="col" class="px-6 py-4">Rombel</th>
                                            <th scope="col" class="px-6 py-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="student in students.data" :key="student" class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-200">
                                                <td class="whitespace-nowrap px-6 py-2 font-medium">{{ nomor++ }}</td>
                                                <td class="whitespace-nowrap px-6 py-2">{{ student.nisn }}</td>
                                                <td class="whitespace-nowrap px-6 py-2">{{ student.fullname }}</td>
                                                <td class="whitespace-nowrap px-6 py-2">{{ student.group }}</td>
                                                <td class="whitespace-nowrap px-6 py-2">
                                                    <Link :href="`/master/siswa/${student.id}/edit`">Edit</Link> 
                                                    |
                                                    <Link :href="`/master/siswa/${student.id}`" method="delete" onclick="return confirm('Anda yakin??')">Hapus</Link> 
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <Pagination :data="students"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Content-->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Inertia } from "@inertiajs/inertia";
import { debounce } from 'lodash';
import { ref, watch } from 'vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    students: Object,
    filters: Object
})

let nomor = 1 ;
let search = ref(props.filters.search);

const debouncedSearch = debounce(value => {
  Inertia.get(
    "/master/siswa",
    { search: value },
    { preserveState: true }
  );
}, 500); // Waktu tunda 500ms (0.5 detik)

watch(search, debouncedSearch);
</script>