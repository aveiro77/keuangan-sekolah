<template>
    <Head title="Rekening" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <Link href="/konfigurasi"> Konfigurasi</Link>
                </h2>
                <nav class="ml-4 w-full rounded-md">
                    <ol class="list-reset flex">
                        <li>
                        <span class="mx-2 text-neutral-500 dark:text-neutral-400">/</span>
                        </li>
                        <li class="text-neutral-500 dark:text-neutral-400">Periode Laporan</li>
                    </ol>
                </nav>
            </div>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/2">
                <!--Place content here-->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                       
                    
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-outline-dark rounded-0 " data-bs-toggle="modal" data-bs-target="#newDataModal">
                        Tambah Periode
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="newDataModal" tabindex="-1" aria-labelledby="newDataModalLabel" aria-hidden="true">
                            <form @submit.prevent="form.post(`/konfigurasi/periode-laporan/create`)" class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="newDataModalLabel">Tambah Periode</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3 row">
                                        <label for="staticPeriod" class="col-sm-2 col-form-label">Periode</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control-plaintext" maxlength="9" v-model="form.newPeriod" id="staticPeriod" >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="staticPeriod" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control-plaintext" id="staticPeriod" v-model="form.newActive" placeholder="Inactive" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-0" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-sm btn-outline-primary rounded-0" data-bs-dismiss="modal">Simpan</button>
                                </div>
                                </div>
                            </form>
                        </div>

                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        <table class="table table-sm min-w-full text-left text-sm font-light">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr>
                                                <th scope="col" class="px-6 py-4">Periode</th>
                                                <th scope="col" class="px-6 py-4">Status</th>
                                                <th scope="col" class="px-6 py-4 text-center">Pengaturan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="period in props.periods" :key="period" class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-200">
                                                <td class="whitespace-nowrap px-6 py-2 font-medium">{{ period.period }}</td>
                                                <td class="whitespace-nowrap px-6 py-2 font-medium">
                                                    <span class="badge rounded-pill text-bg-primary" v-if="period.active == 1">Active</span>
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-2 text-center">
                                                    <button data-bs-toggle="modal" :data-bs-target="'#staticBackdrop' + period.period" @click="clickHandler(period)">
                                                    Atur
                                                    </button>
                                                    <div :id="'staticBackdrop' + period.period" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" :aria-labelledby="'staticBackdropLabel' + period.period" aria-hidden="true">
                                                        <form @submit.prevent="form.put(`/konfigurasi/periode-laporan/update/${period.id}`)" class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" :id="'staticBackdropLabel' + period.period">Pengaturan Periode</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3 row">
                                                                        <label for="staticPeriod" class="col-sm-2 col-form-label">Periode</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control-plaintext" id="staticPeriod" :value="period.period" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label for="active" class="col-sm-2 col-form-label">Status</label>
                                                                        <div class="col-sm-10">
                                                                            <select class="form-select form-select-sm" name="active" aria-label=".form-select-sm example" v-model="form.active">
                                                                                <option :value="1">Active</option>
                                                                                <option :value="0">Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-0" data-bs-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-sm btn-outline-primary rounded-0" data-bs-dismiss="modal">Terapkan</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end content-->
            </div>
        </div>

        <template #footer>
            <h2 class="text-gray-500">Periode : {{ period }}</h2>
        </template>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
  periods: Object,
  period: String,
});

const form = useForm({
  active: '',
  newActive: 'Inactive',
  newPeriod: '',
});

const clickHandler = (period) => {
  form.active = period.active;
};
</script>
