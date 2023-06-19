<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::factory()->create([
            'name' => 'Jumhan',
            'email' => 'jumhan@gmail.com',
            'password' => Hash::make('Jumhan01'),
        ]);

        \App\Models\Coa::factory()->create([
            'code' => '1.1',
            'name' => 'Kas Besar',
            'year' => '2023',
            'initial_balance' => 0,
        ]);

        \App\Models\Coa::factory()->create([
            'code' => '1.2',
            'name' => 'Kas Kecil',
            'year' => '2023',
            'initial_balance' => 0,
        ]);

        \App\Models\Coa::factory()->create([
            'code' => '1.3',
            'name' => 'Bank NISP XXX',
            'year' => '2023',
            'initial_balance' => 1000000,
        ]);

        \App\Models\Student::factory()->create([
            'nisn' => 'JT/NISN/001',
            'fullname' => 'Victor Jansen',
            'group' => '01',
            'year' => '2023',
        ]);

        \App\Models\Student::factory()->create([
            'nisn' => 'JT/NISN/002',
            'fullname' => 'Victor Axelsen',
            'group' => '01',
            'year' => '2023',
        ]);

        \App\Models\Student::factory()->create([
            'nisn' => 'JT/NISN/003',
            'fullname' => 'Lee Chong Wei',
            'group' => '01',
            'year' => '2023',
        ]);

        \App\Models\Due::factory()->create([
            'name' => 'Iuran Bulanan Kelas 1',
            'total_amount' => 400000,
            'group' => '01',
            'year' => '2023',
        ]);

        \App\Models\Due::factory()->create([
            'name' => 'Iuran Bulanan Kelas 2',
            'total_amount' => 500000,
            'group' => '02',
            'year' => '2023',
        ]);


        \App\Models\Partner::create([
            'name' => 'Prima Stationery',
            'address' => 'Jl. KHM. Mansyur Pekalongan',
        ]);

        \App\Models\Income::factory()->create([
            'trn' => 'xxx-xxxx-xxxx',
            'date' => '2023-05-30',
            'description' => 'tes',
            'coa_id' => 1,
            'user_id' => 1,
            'source' => 'BOS',
            'amount' => 20000000,
        ]);

        /*
        \App\Models\Transaction::create([
            'trn' => '#1',
            'date' => '2023-05-20',
            'description' => 'Buku tulis untuk keperluan ujian akhir',
            'partner_id' => 1,
            'coa_id' => 1,
            'user_id' => 1,
            'sub_total' => 150000,
            'tax' => 'NONE',
            'ppn' => 0,
            'grand_total' => 150000
        ]);

        \App\Models\TransactionDetail::create([
            'description' => 'Beli buku halus 10 pack',
            'transaction_id' => 1,
            'qty' => 10,
            'price' => 15000,
            'ppn' => 0,
            'sub_total' => 150000,
        ]);
        */

        DB::table('active_year')->insert([
            ['id' => 1, 'year' => '2020', 'active' => '0'],
            ['id' => 2, 'year' => '2021', 'active' => '0'],
            ['id' => 3, 'year' => '2022', 'active' => '0'],
            ['id' => 4, 'year' => '2023', 'active' => '1'],
        ]);
    }
}
