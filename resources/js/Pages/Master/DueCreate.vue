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
                            <Link href="/master/iuran" class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">Iuran</Link>
                        </li>
                        <li>
                            <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li class="text-neutral-500 dark:text-neutral-400">Form Tambah Iuran</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900" >
                        <!---->
                        <form class="row g-3" @submit.prevent="form.post('/master/iuran')">
                            <div class="col-md-6">
                                <label for="inputyear" class="form-label">Periode</label>
                                <input type="text" class="form-control" id="inputperiod" name="period" v-model="form.period" disabled>
                            </div>
                            <div class="col-md-6" id="selectt">
                                <label for="inputgroup" class="form-label">Rombongan Belajar</label>
                                <select id="inputgroup" class="form-select" name="group" v-model="form.group">
                                    <option value="">== Pilih ==</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="03">04</option>
                                    <option value="03">05</option>
                                    <option value="03">06</option>
                                </select>     
                            </div>
                           
                            <div class="col-12">
                                <label for="inputName" class="form-label">Nama Iuran</label>
                                <input type="text" class="form-control" id="inputName" name="inputName" v-model="form.name">
                                <span class="text-sm text-danger" v-if="form.errors.name">{{form.errors.name }}</span>
                            </div>

                            <div class="col-md-6">
                                <label for="inputamount" class="form-label">Jumlah</label>
                                <input type="text" class="form-control" id="inputamount" name="amount" v-model="form.total_amount">
                                <span class="text-sm text-danger" v-if="form.errors.amount">{{form.errors.total_amount }}</span>
                            </div>

                            <div class="col-md-6" id="selectt">
                                <label for="type" class="form-label">Kelompok</label>
                                <select id="type" class="form-select" name="type" v-model="form.type">
                                    <option value="">== Pilih ==</option>
                                    <option value="SPP">SPP</option>
                                    <option value="NON SPP">NON SPP</option>
                                </select>     
                            </div>

                            <div class="col-12">
                                <input type="hidden" name="active_year_id" v-model="form.active_year_id">
                                <button type="submit" class="btn btn-outline-dark rounded-0 w-1/2 mt-3">Simpan</button>
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

const props = defineProps({
    period: String,
    active_year_id: Number,
});

const form = useForm({
    name: '',
    total_amount: '',
    type: '',
    group: '',
    period: props.period,
    active_year_id: props.active_year_id,
    
});



</script>