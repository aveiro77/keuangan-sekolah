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
use App\Http\Controllers\ConfigController;
use App\Models\Spp_transaction;
use App\Models\Transaction;
use App\Models\Income;
use App\Models\ActiveYear;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Carbon\Carbon;

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

/*
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
*/

Route::redirect('/', '/login');

/*
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::get('/dashboard', function () {
    $activeYear = ActiveYear::where('active', 1)->first();

    $currentMonth = Carbon::now()->month;
    $currentDate = Carbon::now()->format('Y-m-d');

    $due = Spp_transaction::whereYear('date', $activeYear->year)->sum('amount');
    $due_todate = Spp_transaction::whereMonth('date', $currentMonth)->sum('amount');
    $due_today = Spp_transaction::whereDate('date', $currentDate)->sum('amount');

    $income = Income::whereYear('date', $activeYear->year)->sum('amount');
    $income_todate = Income::whereMonth('date', $currentMonth)->sum('amount');
    $income_today = Income::whereDate('date', $currentDate)->sum('amount');

    $outcome = Transaction::whereYear('date', $activeYear->year)->sum('grand_total');
    $outcome_todate = Transaction::whereMonth('date', $currentMonth)->sum('grand_total');
    $outcome_today = Transaction::whereDate('date', $currentDate)->sum('grand_total');

    return Inertia::render('Dashboard')->with([
        'due' => $due,
        'income' => $income,
        'dueToDate' => $due_todate,
        'incomeToDate' => $income_todate,
        'dueToDay' => $due_today,
        'incomeToDay' => $income_today,
        'outcome' => $outcome,
        'outcomeToDate' => $outcome_todate,
        'outcomeToDay' => $outcome_today,
        'period' => $activeYear->period,
    ]);
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

    Route::get('konfigurasi/master-data', [ConfigController::class, 'masters'])->name('konfigurasi.master-data');
    Route::post('konfigurasi/master-rekening/create', [ConfigController::class, 'procMasterCoas'])->name('konfigurasi.master-rekening');
    Route::post('konfigurasi/master-siswa/create', [ConfigController::class, 'procMasterStudents'])->name('konfigurasi.master-siswa');
    Route::post('konfigurasi/master-iuran/create', [ConfigController::class, 'procMasterDues'])->name('konfigurasi.master-iuran');
    Route::post('konfigurasi/master-run', [ConfigController::class, 'runProcedures'])->name('konfigurasi.master-run');

    Route::get('konfigurasi/status-siswa', [ConfigController::class, 'studentsStats'])->name('konfigurasi.status-siswa');
    Route::get('konfigurasi/status-siswa/{id}/edit', [ConfigController::class, 'studentStatsEdit'])->name('konfigurasi.status-siswa.edit');
    Route::put('konfigurasi/status-siswa/update/{id}', [ConfigController::class, 'studentStatsUpdate'])->name('konfigurasi.status-siswa.update');

    Route::get('konfigurasi/periode-laporan', [ConfigController::class, 'periods'])->name('konfigurasi.periode-laporan');
    Route::post('konfigurasi/periode-laporan/create', [ConfigController::class, 'createPeriod'])->name('konfigurasi.periode-laporan.create');
    Route::put('konfigurasi/periode-laporan/update/{id}', [ConfigController::class, 'updatePeriod'])->name('konfigurasi.periode-laporan.update');

    Route::get('/konfigurasi', function () {
        $activeYear = ActiveYear::where('active', 1)->first();
        return Inertia::render('Config/Index', [
            'period' => $activeYear->period,
        ]);
    })->name('konfigurasi');

    Route::get('/master', function () {
        $activeYear = ActiveYear::where('active', 1)->first();
        return Inertia::render('Master/Index', [
            'period' => $activeYear->period,
        ]);
    })->name('master');

    Route::get('/transaksi', function () {
        $activeYear = ActiveYear::where('active', 1)->first();
        return Inertia::render('Transaction/Index', [
            'period' => $activeYear->period,
        ]);
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
        $activeYear = ActiveYear::where('active', 1)->first();
        return Inertia::render('Report/Index', [
            'period' => $activeYear->period,
        ]);
    })->name('laporan');
});

require __DIR__ . '/auth.php';
