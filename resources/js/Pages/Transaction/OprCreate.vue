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
                        <form class="row g-3" @submit.prevent="form.post('/transaksi/opr')">
                                <div class="col-12">
                                    <label for="partner" class="form-label">Rekanan / Suplier</label>
                                    <select id="partner" class="form-select" name="partner" v-model="form.partner_id">
                                        <option value="">Pilih</option>
                                        <option v-for="partner in partners" :key="partner" :value="partner.id">
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
                                        <option value="">Pilih</option>
                                        <option v-for="coa in coas" :key="coa" :value="coa.id">
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

      
        <template #footer>
            <h2 class="text-gray-500">Periode : {{ period }}</h2>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    partners: Object,
    coas: Object,
    period: String,
})

const form = useForm({
    partner_id: '',
    coa_id: '',
    date: '',
    description: '',
    grand_total: 0,
});


/** sctipt ini belum dipake
 * 
import { onMounted } from 'vue';
let i = 0;
function addRow() {
  console.log('klik ' + i);
  ++i;
  var tableBody = document.querySelector('#table tbody');
  var newRow = document.createElement('tr');
  newRow.className = 'border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-200';
  newRow.innerHTML = `
    <td class="whitespace-nowrap px-6 py-2">
      <input type="text" name="inputs[${i}]['description']" class="form-control">
    </td>
    <td class="whitespace-nowrap px-6 py-2">
      <input type="text" name="inputs[${i}]['qty']" class="form-control">
    </td>
    <td class="whitespace-nowrap px-6 py-2">
      <input type="text" name="inputs[${i}]['sub_total']" class="form-control">
    </td>
    <td class="whitespace-nowrap px-6 py-2">
      <button type="button" id="row[${i}]" class="btn btn-outline-danger py-2 px-3 rounded-0" onclick="removeRow(${i})" >Remove</button>
    </td>`;
  tableBody.appendChild(newRow);
}

function removeRow(index) {
  var rowId = [];
  rowId[index] = document.getElementById(`row[${index}]`);
  if (rowId[index]) {
    //rowId[index].parentNode.parentNode.removeChild(rowId[index].parentNode);
    alert('dalem');
  }
}

// Vue Lifecycle Hook
onMounted(() => {
  var addButton = document.getElementById('add');
  addButton.addEventListener('click', addRow);
});
*/

</script>

