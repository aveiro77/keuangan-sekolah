<template>
    <Head title="Konfigurasi" />
  
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Konfigurasi</h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/2">
            
            <div class="alert alert-warning mb-4" role="alert">
                <h4 class="alert-heading"><strong>Perhatian:</strong></h4>
                <p>Harap melakukan konfigurasi secara berurutan sesuai nomor yang tertera.</p>
            </div>

          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 w-full">
            <div class="p-6 text-gray-900">
              <a href="/konfigurasi/periode-laporan">1. Setup Periode Laporan</a>
            </div>
          </div>
  
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4 w-full">
            <div class="p-6 text-gray-900">
              <a href="/konfigurasi/status-siswa">2. Pendataan status siswa (naik kelas / tinggal kelas / transfer / drop out)</a>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4 w-full">
            <div class="p-6 text-gray-900">
              <a href="/konfigurasi/master-data">3. Setup Master Data</a>
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

defineProps({
    period: String,
});
</script>
