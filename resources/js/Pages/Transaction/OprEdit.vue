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
                            <Link href="/transaksi/opr" class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">Operasional</Link>
                        </li>
                        <li>
                            <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li class="text-neutral-500 dark:text-neutral-400">Form Input Operasional</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form class="row g-3" @submit.prevent="form.put(`/transaksi/opr/${transaction.id}`)">
                                <div class="col-md-6">
                                    <h1 class="text-danger"><strong>EDIT {{ form.trn }}</strong></h1>
                                </div>
                                <div class="col-12">
                                    <label for="partner" class="form-label">Rekanan / Suplier</label>
                                    <select id="partner" class="form-select" name="partner" v-model="form.partner_id">
                                        <option v-for="partner in partners" :key="partner" :value="partner.id" :selected="form.partner_id === partner.id">
                                            {{ partner.name }}
                                             ::
                                            {{ partner.address }}
                                        </option>
                                    </select>
                                    <span class="text-sm text-danger" v-if="form.errors.partner_id">{{form.errors.partner_id }}</span>
                                </div>
                                <div class="col-12" id="selectt">
                                    <label for="coa" class="form-label">Rekening</label>
                                    <select id="coa" class="form-select" name="coa" v-model="form.coa_id">
                                        <option v-for="coa in coas" :key="coa" :value="coa.id" :selected="form.coa_id === coa.id">
                                            {{ coa.name }}
                                        </option>
                                    </select>
                                    <span class="text-sm text-danger" v-if="form.errors.coa_id">{{form.errors.coa_id }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputdate" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="inputdate" name="date" v-model="form.date">
                                    <span class="text-sm text-danger" v-if="form.errors.date">{{form.errors.date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label for="grandTotal" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="grandTotal" name="grand_total" v-model="form.grand_total">
                                    <span class="text-sm text-danger" v-if="form.errors.grand_total">{{form.errors.grand_total }}</span>
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
                                    <Link href="/transaksi/opr" class="btn btn-sm btn-outline-primary rounded-0 w-full">Kembali</Link>
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
    trn: props.transaction.trn,
    partner_id: props.transaction.partner_id,
    coa_id: props.transaction.coa_id,
    date: props.transaction.date,
    description: props.transaction.description,
    grand_total: props.transaction.grand_total,
});

const props = defineProps({
    partners: Object,
    coas: Object,
    transaction: Object,
});

</script>

