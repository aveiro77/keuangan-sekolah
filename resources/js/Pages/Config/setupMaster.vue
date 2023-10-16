<template>
    <Head title="Konfigurasi" />

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
                        <li class="text-neutral-500 dark:text-neutral-400">Setup Master Data</li>
                    </ol>
                </nav>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="my-3">
                            Berikan tanda centang pada pilihan yang ingin dieksekusi:
                            <hr>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="cbCoas" name="coas"
                                v-model="cbCoas" :disabled="loadingVisible">
                            <label class="form-check-label" for="cbCoas">
                                Duplikat master rekening periode sebelumnya
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="cbStudents" name="students"
                                v-model="cbStudents" :disabled="loadingVisible">
                            <label class="form-check-label" for="cbStudents">
                                Update rombel data siswa secara masal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="cbDues" name="dues"
                                v-model="cbDues" :disabled="loadingVisible">
                            <label class="form-check-label" for="cbDues">
                                Duplikat master iuran siswa periode sebelumnya
                            </label>
                        </div>

                        <button id="process" type="button" class="btn btn-sm btn-outline-primary mt-3" @click="startLoading"
                            :disabled="loadingVisible">Proses</button>

                        <div id="status" v-show="statusVisible">
                            <div class="alert alert-primary alert-dismissible fade show mt-3" role="alert">
                                <div id="procOne-msg">

                                </div>
                                <div id="procTwo-msg">

                                </div>
                                <div id="procThree-msg">

                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>



                        <div id="loading" v-show="loadingVisible" style="display: none;">
                            <div class="d-flex align-items-center mt-3">
                                <strong>Loading...</strong>
                                <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <template #footer>
            <h2 class="text-gray-500">Periode : {{ period }}</h2>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

defineProps({
    period: String,
});

const cbCoas = ref(false);
const cbStudents = ref(false);
const cbDues = ref(false);
const loadingVisible = ref(false);
const statusVisible = ref(false);

const startLoading = () => {

    if (cbCoas.value || cbStudents.value || cbDues.value) {
        loadingVisible.value = true;
    }

    if (cbCoas.value) {
        console.log('Proc 1 running');
        callProcedure1();
    }

    if (cbStudents.value) {
        console.log('Proc 2 running');
        callProcedure2();
    }

    if (cbDues.value) {
        console.log('Proc 3 running');
        callProcedure3();
    }
};

const callProcedure1 = () => {
    axios.post('/konfigurasi/master-rekening/create')
        .then(response => {
            console.log('Proc 1 response:', response.data.messageCoa);
            loadingVisible.value = response.data.status;
            statusVisible.value = response.data.status + 1;

            // Showing the message into element with ID "procOne-msg"
            const procOneMsg = document.getElementById('procOne-msg');
            if (procOneMsg) {
                procOneMsg.innerHTML = `Message: Proses pengaturan data <strong>${response.data.messageCoa}</strong>`;
            }
        })
        .catch(error => {
            console.error('Proc 1 error:', error);
        });
};

const callProcedure2 = () => {
    axios.post('/konfigurasi/master-siswa/create')
        .then(response => {
            console.log('Proc 2 response:', response.data.message);
            loadingVisible.value = response.data.status;
            statusVisible.value = response.data.status + 1;

            // Showing the message into element with ID "procTwo-msg"
            const procTwoMsg = document.getElementById('procTwo-msg');
            if (procTwoMsg) {
                procTwoMsg.innerHTML = `Message: Proses Update <strong>${response.data.messageStudents}</strong>`;
            }
        })
        .catch(error => {
            console.error('Proc 2 error:', error);
        });
};

const callProcedure3 = () => {
    axios.post('/konfigurasi/master-iuran/create')
        .then(response => {
            console.log('Proc 3 response:', response.data.message);
            loadingVisible.value = response.data.status;
            statusVisible.value = response.data.status + 1;

            // Showing the message into element with ID "procThree-msg"
            const procThreeMsg = document.getElementById('procThree-msg');
            if (procThreeMsg) {
                procThreeMsg.innerHTML = `Message: Proses Update <strong>${response.data.messageDues}</strong>`;
            }
        })
        .catch(error => {
            console.error('Proc 3 error:', error);
        });
};

</script>
