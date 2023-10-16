<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Spp_transaction;
use App\Models\Transaction;
use App\Models\ActiveYear;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use PDF;

class ReportController extends Controller
{
    public function accountBalance()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $result = DB::table('coas')
            ->leftJoin('journal', 'coas.id', '=', 'journal.coa_id')
            ->select(
                'coas.id',
                'coas.code',
                'coas.name',
                DB::raw('COALESCE(coas.initial_balance, 0) AS `M00`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 1 THEN journal.debit - journal.credit END), 0) AS `M01`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 2 THEN journal.debit - journal.credit END), 0) AS `M02`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 3 THEN journal.debit - journal.credit END), 0) AS `M03`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 4 THEN journal.debit - journal.credit END), 0) AS `M04`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 5 THEN journal.debit - journal.credit END), 0) AS `M05`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 6 THEN journal.debit - journal.credit END), 0) AS `M06`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 7 THEN journal.debit - journal.credit END), 0) AS `M07`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 8 THEN journal.debit - journal.credit END), 0) AS `M08`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 9 THEN journal.debit - journal.credit END), 0) AS `M09`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 10 THEN journal.debit - journal.credit END), 0) AS `M10`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 11 THEN journal.debit - journal.credit END), 0) AS `M11`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 12 THEN journal.debit - journal.credit END), 0) AS `M12`')
            )
            ->where('coas.active_year_id', $active_year->id)
            ->groupBy(
                'coas.id',
                'coas.active_year_id',
                'coas.code',
                'coas.name',
                'coas.initial_balance'
            )
            ->get();

        return Inertia::render('Report/AccountBalance', [
            'data' => $result,
            'title' => 'Laporan Saldo Rekening Periode ' . $active_year->period,
            'period' => $active_year->period,
        ]);
    }

    public function accountBalancePrint()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $result = DB::table('coas')
            ->leftJoin('journal', 'coas.id', '=', 'journal.coa_id')
            ->select(
                'coas.id',
                'coas.code',
                'coas.name',
                DB::raw('COALESCE(coas.initial_balance, 0) AS `M00`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 1 THEN journal.debit - journal.credit END), 0) AS `M01`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 2 THEN journal.debit - journal.credit END), 0) AS `M02`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 3 THEN journal.debit - journal.credit END), 0) AS `M03`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 4 THEN journal.debit - journal.credit END), 0) AS `M04`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 5 THEN journal.debit - journal.credit END), 0) AS `M05`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 6 THEN journal.debit - journal.credit END), 0) AS `M06`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 7 THEN journal.debit - journal.credit END), 0) AS `M07`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 8 THEN journal.debit - journal.credit END), 0) AS `M08`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 9 THEN journal.debit - journal.credit END), 0) AS `M09`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 10 THEN journal.debit - journal.credit END), 0) AS `M10`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 11 THEN journal.debit - journal.credit END), 0) AS `M11`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(journal.date) = 12 THEN journal.debit - journal.credit END), 0) AS `M12`')
            )
            ->where('coas.active_year_id', $active_year->id)
            ->groupBy(
                'coas.id',
                'coas.active_year_id',
                'coas.code',
                'coas.name',
                'coas.initial_balance'
            )
            ->get();

        $pdf = PDF::loadview('pdf.account_balance', [
            'result' => $result,
            'title' => 'Laporan Saldo Rekening Periode ' . $active_year->period
        ]);
        $pdf->setPaper('a4', 'landscape');

        //return $pdf->download('saldo-rekening-' . $active_year[0] . '.pdf'); 
        return $pdf->stream();
    }

    public function monthlyDues()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $result = DB::table('students as s')
            ->leftJoin('spp_transactions as spp', 's.id', '=', 'spp.student_id')
            ->leftJoin('dues as d', 'spp.due_id', '=', 'd.id')
            ->select(
                's.nisn',
                's.fullname',
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 1 THEN spp.amount END), 0) AS `M01`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 2 THEN spp.amount END), 0) AS `M02`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 3 THEN spp.amount END), 0) AS `M03`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 4 THEN spp.amount END), 0) AS `M04`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 5 THEN spp.amount END), 0) AS `M05`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 6 THEN spp.amount END), 0) AS `M06`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 7 THEN spp.amount END), 0) AS `M07`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 8 THEN spp.amount END), 0) AS `M08`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 9 THEN spp.amount END), 0) AS `M09`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 10 THEN spp.amount END), 0) AS `M10`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 11 THEN spp.amount END), 0) AS `M11`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 12 THEN spp.amount END), 0) AS `M12`')
            )
            ->where('s.active_year_id', $active_year->id)
            ->where('d.type', 'SPP')
            ->groupBy('s.active_year_id', 's.nisn', 's.fullname')
            ->get();
        return Inertia::render('Report/MonthlyDues', [
            'data' => $result,
            'title' => 'Laporan Iuran SPP Periode ' . $active_year->period,
            'period' => $active_year->period,
        ]);
    }

    public function monthlyDuesPrint()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $result = DB::table('students as s')
            ->leftJoin('spp_transactions as spp', 's.id', '=', 'spp.student_id')
            ->leftJoin('dues as d', 'spp.due_id', '=', 'd.id')
            ->select(
                's.nisn',
                's.fullname',
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 1 THEN spp.amount END), 0) AS `M01`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 2 THEN spp.amount END), 0) AS `M02`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 3 THEN spp.amount END), 0) AS `M03`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 4 THEN spp.amount END), 0) AS `M04`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 5 THEN spp.amount END), 0) AS `M05`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 6 THEN spp.amount END), 0) AS `M06`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 7 THEN spp.amount END), 0) AS `M07`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 8 THEN spp.amount END), 0) AS `M08`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 9 THEN spp.amount END), 0) AS `M09`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 10 THEN spp.amount END), 0) AS `M10`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 11 THEN spp.amount END), 0) AS `M11`'),
                DB::raw('COALESCE(SUM(CASE WHEN MONTH(spp.date) = 12 THEN spp.amount END), 0) AS `M12`')
            )
            ->where('s.active_year_id', $active_year->id)
            ->where('d.type', 'SPP')
            ->groupBy('s.active_year_id', 's.nisn', 's.fullname')
            ->get();

        $pdf = PDF::loadview('pdf.monthly_dues', [
            'result' => $result,
            'title' => 'Laporan Iuran SPP Periode ' . $active_year->period
        ]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function nonSppDues()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $result = Spp_Transaction::with(['User', 'Due', 'Student'])
            ->whereYear('date', $active_year->year)
            ->whereHas('Due', function ($query) {
                $query->where('type', 'NON SPP');
            })
            ->get();


        return Inertia::render('Report/NonSppDues', [
            'data' => $result,
            'title' => 'Laporan Iuran Non SPP Periode ' . $active_year->period,
            'period' => $active_year->period,
        ]);
    }

    public function nonSppDuesPrint()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $result = Spp_Transaction::with(['User', 'Due', 'Student'])
            ->whereYear('date', $active_year->year)
            ->whereHas('Due', function ($query) {
                $query->where('type', 'NON SPP');
            })
            ->get();

        $pdf = PDF::loadview('pdf.non_spp_dues', [
            'result' => $result,
            'title' => 'Laporan Iuran Non SPP Periode ' . $active_year->period
        ]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function outcome()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $result = Transaction::with(['User', 'Due', 'Coa', 'Partner'])
            ->whereYear('date', $active_year->year)->get();

        return Inertia::render('Report/Outcome', [
            'data' => $result,
            'title' => 'Laporan Pengeluaran Periode ' . $active_year->period,
            'period' => $active_year->period,
        ]);
    }

    public function outcomePrint()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $result = Transaction::with(['User', 'Due', 'Coa', 'Partner'])
            ->whereYear('date', $active_year->year)->get();

        $pdf = PDF::loadview('pdf.outcomes', [
            'result' => $result,
            'title' => 'Laporan Pengeluaran Periode ' . $active_year->period
        ]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function income()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $result = Income::whereYear('date', $active_year->year)->get();

        return Inertia::render('Report/Income', [
            'data' => $result,
            'title' => 'Laporan Pemasukan Periode ' . $active_year->period,
            'period' => $active_year->period,
        ]);
    }

    public function incomePrint()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $result = Income::whereYear('date', $active_year->year)->get();

        $pdf = PDF::loadview('pdf.incomes', [
            'result' => $result,
            'title' => 'Laporan Pemasukan Periode ' . $active_year->period
        ]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
