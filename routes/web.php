<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CoaController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DueController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\SppTransactionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MutationController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ReportController;
use App\Models\Income;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('master/iuran', DueController::class);
    Route::resource('master/rekanan', PartnerController::class);
    Route::resource('master/rekening', CoaController::class);
    Route::resource('master/siswa', StudentController::class);
    Route::resource('transaksi/spp', SppTransactionController::class);
    Route::resource('transaksi/opr', TransactionController::class);
    Route::resource('transaksi/mutasi', MutationController::class);
    Route::resource('transaksi/pemasukan', IncomeController::class);

    Route::get('/master', function () {
        return Inertia::render('Master/Index');
    })->name('master');

    Route::get('/transaksi', function () {
        return Inertia::render('Transaction/Index');
    })->name('transaksi');

    Route::get('/laporan/saldo-rekening', [ReportController::class, 'accountBalance'])->name('laporan.saldo-rekening');
    Route::get('/laporan/saldo-rekening-print', [ReportController::class, 'accountBalancePrint'])->name('laporan.saldo-rekening-print');
    Route::get('/laporan/iuran-spp', [ReportController::class, 'monthlyDues'])->name('laporan.iuran-spp');
    Route::get('/laporan/iuran-spp-print', [ReportController::class, 'monthlyDuesPrint'])->name('laporan.iuran-spp-print');
    Route::get('/laporan/pengeluaran', [ReportController::class, 'outcome'])->name('laporan.pengeluaran');
    Route::get('/laporan/pengeluaran-print', [ReportController::class, 'outcomePrint'])->name('laporan.pengeluaran-print');
    Route::get('/laporan/pemasukan', [ReportController::class, 'income'])->name('laporan.pemasukan');
    Route::get('/laporan/pemasukan-print', [ReportController::class, 'incomePrint'])->name('laporan.pemasukan-print');
    Route::get('/laporan/iuran-non-spp', [ReportController::class, 'nonSppDues'])->name('laporan.iuran-non-spp');
    Route::get('/laporan/iuran-non-spp-print', [ReportController::class, 'nonSppDuesPrint'])->name('laporan.iuran-non-spp-print');
    Route::get('/laporan', function () {
        return Inertia::render('Report/Index');
    })->name('laporan');
});

require __DIR__ . '/auth.php';
