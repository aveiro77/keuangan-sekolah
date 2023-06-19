<template>
    <Head title="Edit Iuran Siswa" />

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
                            <Link href="/transaksi/spp" class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">Iuran Siswa</Link>
                        </li>
                        <li>
                            <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li class="text-neutral-500 dark:text-neutral-400">Form Edit Iuran Siswa</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900" >
                        <!---->
                        <form class="row g-3" @submit.prevent="form.put(`/transaksi/spp/${trans.id}`)">
                            <div class="col-md-6">
                                <h1 class="text-danger"><strong>EDIT {{ form.trn }}</strong></h1>
                            </div>
                            <div class="col-12">
                                <label for="siswa" class="form-label">NISN :: Rombel :: Nama Siswa</label>
                                <select id="siswa" class="form-select" name="siswa" v-model="form.student_id">
                                    <option v-for="student in students" :key="student" :value="student.id" :selected="form.student_id === student.id">
                                        {{ student.nisn }}::{{ student.group }}::{{ student.fullname }}
                                    </option>
                                </select>
                                <span class="text-sm text-danger" v-if="form.errors.student_id">{{form.errors.student_id }}</span>
                            </div>
                            <div class="col-12" id="selectt">
                                <label for="due" class="form-label">Jenis Iuran</label>
                                <select id="due" class="form-select" name="due" v-model="form.due_id">
                                    <option v-for="due in dues" :key="due" :value="due.id" :selected="form.due_id === due.id">
                                        {{ due.name }}
                                    </option>
                                </select>
                                <span class="text-sm text-danger" v-if="form.errors.due_id">{{form.errors.due_id }}</span>
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
                                <label for="total_amount" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="total_amount" name="total_amount" v-model="form.total_amount">
                                <span class="text-sm text-danger" v-if="form.errors.total_amount">{{form.errors.total_amount }}</span>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Keterangan</label>
                                    <textarea class="form-control rounded-0" id="description" name="description" rows="3" v-model="form.description">{{ form.description }}</textarea>
                                    <span class="text-sm text-danger" v-if="form.errors.description">{{form.errors.description }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-sm btn-outline-dark rounded-0 px-5 w-full">Simpan</button>
                            </div>
                            <div class="col-md-6">
                                <Link href="/transaksi/spp" class="btn btn-sm btn-outline-primary rounded-0 px-5 w-full">Batal</Link>
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


const form = useForm({
    trn: props.trans.trn,
    student_id: props.trans.student_id,
    due_id: props.trans.due_id,
    coa_id: props.trans.coa_id,
    date: props.trans.date,
    total_amount: props.trans.amount,
    description: props.trans.description,
});

const props = defineProps({
    trans: Object,
    students: Object,
    dues: Object,
    coas: Object,
})


</script>