<template>
    <Head title="Edit Rekening" />

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
                            <Link href="/master/rekening" class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">Rekening</Link>
                        </li>
                        <li>
                            <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li class="text-neutral-500 dark:text-neutral-400">Form Edit Rekening</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900" >
                        <!---->
                        <form class="row g-3" @submit.prevent="form.put(`/master/rekening/${coa.id}`)">
                            <div class="col-md-6">
                                <label for="inputCode" class="form-label">Kode</label>
                                <input type="text" class="form-control" id="inputCode" name="inputCode" v-model="form.code">
                                <span class="text-sm text-danger" v-if="form.errors.code">{{form.errors.code }}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="inputTCode" class="form-label">Periode</label>
                                <input type="text" class="form-control" id="inputTCode" name="inputTCode" v-model="form.period" disabled>
                            </div>
                            <div class="col-12">
                                <label for="inputName" class="form-label">Nama Rekening</label>
                                <input type="text" class="form-control" id="inputName" name="inputName" v-model="form.name">
                                <span class="text-sm text-danger" v-if="form.errors.name">{{form.errors.name }}</span>
                            </div>
                            <div class="col-md-9">
                                <label for="initialBalance" class="form-label">Saldo Awal</label>
                                <input type="text" class="form-control" id="initial" name="initial_balance" v-model="form.initial_balance">
                                <span class="text-sm text-danger" v-if="form.errors.initial_balance">{{form.errors.initial_balance }}</span>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-sm btn-outline-dark rounded-0 px-5 w-full mt-3">Simpan</button>
                            </div>
                            <div class="col-md-6">
                                <Link href="/master/rekening" class="btn btn-sm btn-outline-primary rounded-0 px-5 w-full mt-3">Batal</Link>
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
    code: props.coa.code,
    name: props.coa.name,
    period: props.coa.active_year.period,
    initial_balance: props.coa.initial_balance,
});

const props = defineProps({
    coa: Object,
})


</script>