<template>
    <Head title="Edit Status Siswa" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <Link href="/master">Konfigurasi</Link>
                </h2>
                <nav class="ml-4 w-full rounded-md">
                    <ol class="list-reset flex">
                        <li>
                        <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li>
                            <Link href="/konfigurasi/status-siswa" class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">Status Siswa</Link>
                        </li>
                        <li>
                            <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li class="text-neutral-500 dark:text-neutral-400">Form Edit Status Siswa</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900" >
                        <!---->
                        <form class="row g-3" @submit.prevent="form.put(`/konfigurasi/status-siswa/update/${student.id}`)">
                            <div class="col-md-6">
                                <label for="inputnisn" class="form-label">NISN</label>
                                <input type="text" class="form-control" id="inputnisn" name="nisn" v-model="form.nisn" disabled>
                            </div>
                            <div class="col-12">
                                <label for="inputName" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="inputName" name="inputName" v-model="form.fullname" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="temp_status" class="form-label">Status</label>
                                <select id="temp_status" name="temp_status" class="form-select" v-model="form.temp_status">
                                    <option :value="'NK'" :selected="form.temp_status === 'NK'">Naik Kelas</option>
                                    <option :value="'TK'" :selected="form.temp_status === 'TK'">Tinggal Kelas</option>
                                    <option :value="'TF'" :selected="form.temp_status === 'TF'">Transfer</option>
                                    <option :value="'DO'" :selected="form.temp_status === 'DO'">Drop Out</option>
                                </select>
                            </div>

                            <div class="col-6 pt-3">
                                <button type="submit" class="btn w-full btn-outline-dark rounded-0">Simpan</button>
                            </div>
                            <div class="col-md-6">
                                <Link href="/konfigurasi/status-siswa" class="btn btn-outline-primary rounded-0 px-5 w-full mt-3">Batal</Link>
                            </div>
                        </form>
                        <!---->
                    </div>
                </div>
            </div>
        </div>

        <template #footer>
            <h2 class="text-gray-500">Periode : {{ form.period }}</h2>
        </template>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

var curYear = new Date().getFullYear();

const form = useForm({
    nisn: props.student.nisn,
    fullname: props.student.fullname,
    temp_status: props.student.temp_status,
});

const props = defineProps({
    student: Object,
})


</script>