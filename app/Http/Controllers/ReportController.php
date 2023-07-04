<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Spp_transaction;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use PDF;

class ReportController extends Controller
{
    public function accountBalance()
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');
        $result = DB::table('coas')
            ->leftJoin('journal', 'coas.id', '=', 'journal.coa_id')
            ->select(
                'coas.id',
                'coas.year',
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
            ->where('coas.year', $active_year[0])
            ->groupBy(
                'coas.id',
                'coas.year',
                'coas.code',
                'coas.name',
                'coas.initial_balance'
            )
            ->get();

        return Inertia::render('Report/AccountBalance', [
            'data' => $result,
            'year' => $active_year[0],
        ]);
    }

    public function accountBalancePrint()
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');
        $result = DB::table('coas')
            ->leftJoin('journal', 'coas.id', '=', 'journal.coa_id')
            ->select(
                'coas.id',
                'coas.year',
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
            ->where('coas.year', $active_year[0])
            ->groupBy(
                'coas.id',
                'coas.year',
                'coas.code',
                'coas.name',
                'coas.initial_balance'
            )
            ->get();

        $pdf = PDF::loadview('pdf.account_balance', ['result' => $result, 'year' => $active_year[0]]);
        $pdf->setPaper('a4', 'landscape');

        //return $pdf->download('saldo-rekening-' . $active_year[0] . '.pdf'); 
        return $pdf->stream();
    }

    public function monthlyDues()
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');
        $result = DB::table('students as s')
            ->leftJoin('spp_transactions as spp', 's.id', '=', 'spp.student_id')
            ->leftJoin('dues as d', 'spp.due_id', '=', 'd.id')
            ->select(
                's.year',
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
            ->where('s.year', $active_year[0])
            ->where('d.type', 'SPP')
            ->groupBy('s.year', 's.nisn', 's.fullname')
            ->get();
        return Inertia::render('Report/MonthlyDues', [
            'data' => $result,
            'year' => $active_year[0],
        ]);
    }

    public function monthlyDuesPrint()
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');
        $result = DB::table('students as s')
            ->leftJoin('spp_transactions as spp', 's.id', '=', 'spp.student_id')
            ->leftJoin('dues as d', 'spp.due_id', '=', 'd.id')
            ->select(
                's.year',
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
            ->where('s.year', $active_year[0])
            ->where('d.type', 'SPP')
            ->groupBy('s.year', 's.nisn', 's.fullname')
            ->get();

        $pdf = PDF::loadview('pdf.monthly_dues', ['result' => $result, 'year' => $active_year[0]]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function nonSppDues()
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');
        $result = Spp_Transaction::with(['User', 'Due', 'Student'])
            ->whereYear('date', $active_year[0])
            ->whereHas('Due', function ($query) {
                $query->where('type', 'NON SPP');
            })
            ->get();


        return Inertia::render('Report/NonSppDues', [
            'data' => $result,
            'year' => $active_year[0],
        ]);
    }

    public function nonSppDuesPrint()
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');
        $result = Spp_Transaction::with(['User', 'Due', 'Student'])
            ->whereYear('date', $active_year[0])
            ->whereHas('Due', function ($query) {
                $query->where('type', 'NON SPP');
            })
            ->get();

        $pdf = PDF::loadview('pdf.non_spp_dues', ['result' => $result, 'year' => $active_year[0]]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function outcome()
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');
        $result = Transaction::with(['User', 'Due', 'Coa', 'Partner'])
            ->whereYear('date', $active_year[0])->get();

        return Inertia::render('Report/Outcome', [
            'data' => $result,
            'year' => $active_year[0],
        ]);
    }

    public function outcomePrint()
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');
        $result = Transaction::with(['User', 'Due', 'Coa', 'Partner'])
            ->whereYear('date', $active_year[0])->get();

        $pdf = PDF::loadview('pdf.outcomes', ['result' => $result, 'year' => $active_year[0]]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function income()
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');

        $result = Income::whereYear('date', $active_year[0])->get();

        return Inertia::render('Report/Income', [
            'data' => $result,
            'year' => $active_year[0],
        ]);
    }

    public function incomePrint()
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');

        $result = Income::whereYear('date', $active_year[0])->get();

        $pdf = PDF::loadview('pdf.incomes', ['result' => $result, 'year' => $active_year[0]]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
