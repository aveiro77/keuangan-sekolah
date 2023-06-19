<template>
    <Head title="Edit Siswa" />

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
                        <li class="text-neutral-500 dark:text-neutral-400">Form Edit Siswa</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900" >
                        <!---->
                        <form class="row g-3" @submit.prevent="form.put(`/master/siswa/${student.id}`)">
                            <div class="col-md-6">
                                <label for="inputnisn" class="form-label">NISN</label>
                                <input type="text" class="form-control" id="inputnisn" name="nisn" v-model="form.nisn">
                                <span class="text-sm text-danger" v-if="form.errors.nisn">{{form.errors.nisn }}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="inputgroup" class="form-label">Rombongan Belajar</label>
                                <input type="text" class="form-control" id="inputgroup" name="group" v-model="form.group">
                                <span class="text-sm text-danger" v-if="form.errors.group">{{form.errors.group }}</span>
                            </div>
                            <div class="col-12">
                                <label for="inputName" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="inputName" name="inputName" v-model="form.fullname">
                                <span class="text-sm text-danger" v-if="form.errors.fullname">{{form.errors.fullname }}</span>
                            </div>

                            <div class="col-md-6">
                                <label for="inputyear" class="form-label">Tahun</label>
                                <input type="number" class="form-control" id="inputyear" name="year" v-model="form.year" placeholder="ex: 2023">
                                <span class="text-sm text-danger" v-if="form.errors.year">{{form.errors.year }}</span>
                            </div>
                            <div class="col-12 pt-3">
                                <button type="submit" class="btn w-1/2 btn-outline-dark rounded-0">Simpan</button>
                            </div>
                        </form>
                        <!---->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

var curYear = new Date().getFullYear();

const form = useForm({
    nisn: props.student.nisn,
    fullname: props.student.fullname,
    group: props.student.group,
    year: props.student.year
});

const props = defineProps({
    student: Object,
})


</script>