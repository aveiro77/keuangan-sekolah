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
                            <Link href="/transaksi/mutasi" class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">Mutasi Rekening</Link>
                        </li>
                        <li>
                            <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li class="text-neutral-500 dark:text-neutral-400">Form Edit Mutasi</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form class="row g-3" @submit.prevent="form.put(`/transaksi/mutasi/${mutation.id}`)">
                                <div class="col-md-6">
                                    <h1 class="text-danger"><strong>EDIT {{ form.trn }}</strong></h1>
                                </div>
                                <div class="col-md-12">
                                    <label for="amount" class="form-label">Jumlah yang dimutasi</label>
                                    <input type="number" class="form-control" id="amount" name="amount" v-model="form.amount">
                                    <span class="text-sm text-danger" v-if="form.errors.amount">{{form.errors.amount }}</span>
                                </div>
                                <div class="col-12">
                                    <label for="coa_id" class="form-label">Rekening Sumber (Keluar)</label>
                                    <select id="coa_id" class="form-select" name="coa_id" v-model="form.coa_id">
                                        <option v-for="coa in coas" :key="coa" :value="coa.id" :selected="form.coa_id === coa.id">
                                            {{ coa.name }}
                                             ::
                                            {{ coa.address }}
                                        </option>
                                    </select>
                                    <span class="text-sm text-danger" v-if="form.errors.coa_id">{{form.errors.coa_id }}</span>
                                </div>
                                <div class="col-12">
                                    <label for="coa_id2" class="form-label">Rekening Tujuan (Masuk)</label>
                                    <select id="coa_id2" class="form-select" name="coa_id2" v-model="form.coa_id2">
                                        <option v-for="coa in coas" :key="coa" :value="coa.id" :selected="form.coa_id2 === coa.id">
                                            {{ coa.name }}
                                             ::
                                            {{ coa.address }}
                                        </option>
                                    </select>
                                    <span class="text-sm text-danger" v-if="form.errors.coa_id2">{{form.errors.coa_id2 }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="date" name="date" v-model="form.date">
                                    <span class="text-sm text-danger" v-if="form.errors.date">{{form.errors.date }}</span>
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
                                    <Link href="/transaksi/mutasi" class="btn btn-sm btn-outline-primary rounded-0 w-full">Kembali</Link>
                                </div>
                                <div class="col-md-4">
                                    <button type="reset" value="reset" class="btn btn-sm btn-outline-danger rounded-0 w-full">Bersihkan</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    trn: props.mutation.trn,
    coa_id: props.mutation.coa_id,
    coa_id2: props.mutation.coa_id2,
    date: props.mutation.date,
    description: props.mutation.description,
    amount: props.mutation.credit,
});

const props = defineProps({
    coas: Object,
    mutation: Object,
});

</script>

