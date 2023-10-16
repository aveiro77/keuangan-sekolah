<template>
    <Head title="Tambah Rekening" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <Link href="/master">Master</Link>
                </h2>
                <nav class="ml-4 w-full rounded-md">
                    <ol class="list-reset flex">
                        <li>
                        <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li>
                            <Link href="/master/siswa" class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">Siswa</Link>
                        </li>
                        <li>
                            <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li class="text-neutral-500 dark:text-neutral-400">Form Tambah Siswa</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900" >
                        <!---->
                        <form class="row g-3" @submit.prevent="form.post('/master/siswa')">
                            <div class="col-md-6">
                                <label for="inputnisn" class="form-label">NISN</label>
                                <input type="text" class="form-control" id="inputnisn" name="nisn" v-model="form.nisn" autofocus>
                                <span class="text-sm text-danger" v-if="form.errors.nisn">{{form.errors.nisn }}</span>
                            </div>
                            <div class="col-md-6" id="selectt">
                                <label for="inputgroup" class="form-label">Rombongan Belajar</label>
                                <select id="inputgroup" class="form-select" name="group" v-model="form.group">
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="03">04</option>
                                    <option value="03">05</option>
                                    <option value="03">06</option>
                                </select>     
                            </div>
                           
                            <div class="col-12">
                                <label for="inputName" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="inputName" name="inputName" v-model="form.fullname">
                                <span class="text-sm text-danger" v-if="form.errors.fullname">{{form.errors.fullname }}</span>
                            </div>

                            <div class="col-md-6">
                                <label for="inputyear" class="form-label">Periode</label>
                                <input type="text" class="form-control" id="inputyear" name="year" v-model="form.period" disabled>
                                <span class="text-sm text-danger" v-if="form.errors.year">{{form.errors.year }}</span>
                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6 pt-3">
                                <input type="hidden" class="form-control" id="active_year_id" name="active_year_id" v-model="form.active_year_id">
                                <button type="submit" class="btn w-full btn-outline-dark rounded-0">Simpan</button>
                            </div>
                            <div class="col-md-6">
                                <Link href="/master/siswa" class="btn btn-outline-primary rounded-0 px-5 w-full mt-3">Batal</Link>
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

const props = defineProps({
    period: String,
    active_year_id: Number,
});

const form = useForm({
    nisn: '',
    fullname: '',
    group: '',
    active_year_id: props.active_year_id,
    period: props.period,
});


</script>