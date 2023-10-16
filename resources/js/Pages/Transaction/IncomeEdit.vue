<template>
    <Head title="Transaksi" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <Link href="/transaksi">Transaksi</Link>
                </h2>
                <nav class="ml-4 w-full rounded-md">
                    <ol class="list-reset flex">
                        <li>
                        <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li>
                            <Link href="/transaksi/pemasukan" class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">Pemasukan</Link>
                        </li>
                        <li>
                            <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li class="text-neutral-500 dark:text-neutral-400">Form Input Pemasukan</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form class="row g-3" @submit.prevent="form.put(`/transaksi/pemasukan/${income.id}`)">
                                <div class="col-md-6">
                                    <h1 class="text-danger"><strong>EDIT {{ form.trn }}</strong></h1>
                                </div>
                                <div class="col-12">
                                    <label for="source" class="form-label">Sumber Pemasukan</label>
                                    <select id="source" class="form-select" name="source" v-model="form.source">
                                        <option value="Dana B.O.S" :selected="form.source === `Dana B.O.S`">Dana B.O.S</option>
                                        <option value="Sumbangan Wali Murid /  Instansi" :selected="form.source === `Sumbangan Wali Murid / Instansi`">Sumbangan Wali Murid /  Instansi</option>
                                    </select>
                                    <span class="text-sm text-danger" v-if="form.errors.source">{{form.errors.source }}</span>
                                </div>
                                <div class="col-12" id="selectt">
                                    <label for="coa" class="form-label">Rekening Pemasukan</label>
                                    <select id="coa" class="form-select" name="coa" v-model="form.coa_id">
                                        <option v-for="coa in coas" :key="coa" :value="coa.id" :selected="form.coa_id === coa.id">
                                            {{ coa.name }}
                                        </option>
                                    </select>
                                    <span class="text-sm text-danger" v-if="form.errors.coa_id">{{form.errors.coa_id }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="date" name="date" v-model="form.date">
                                    <span class="text-sm text-danger" v-if="form.errors.date">{{form.errors.date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label for="amount" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="amount" name="amount" v-model="form.amount">
                                    <span class="text-sm text-danger" v-if="form.errors.amount">{{form.errors.amount }}</span>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Keterangan</label>
                                    <textarea class="form-control rounded-0" id="description" name="description" rows="3" v-model="form.description">{{ form.description }}</textarea>
                                    <span class="text-sm text-danger" v-if="form.errors.description">{{form.errors.description }}</span>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-sm btn-outline-dark rounded-0 w-full">Simpan</button>
                                </div>
                                <div class="col-md-4">
                                    <Link href="/transaksi/pemasukan" class="btn btn-sm btn-outline-primary rounded-0 w-full">Kembali</Link>
                                </div>
                                <div class="col-md-4">
                                    <button type="reset" value="reset" class="btn btn-sm btn-outline-danger rounded-0 w-full">Bersihkan</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>

        <template #footer>
            <h2 class="text-gray-500">Periode : {{ props.period }}</h2>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    trn: props.income.trn,
    source: props.income.source,
    coa_id: props.income.coa_id,
    date: props.income.date,
    description: props.income.description,
    amount: props.income.amount,
});

const props = defineProps({
    coas: Object,
    income: Object,
    period: String,
});

</script>

