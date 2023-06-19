<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function accountBalance()
    {
        /**
         * 
         *SELECT
         * a.name,
         * ifnull(b.debit, 0) as debit,
         * ifnull(c.credit, 0) as credit
         * FROM coas a
         * left join (select coa_id, sum(amount) as debit from spp_transactions WHERE year(date) = '2023') b on a.id=b.coa_id
         * left join (select coa_id, sum(grand_total) as credit from transactions WHERE year(date) = '2023') c on a.id=c.coa_id
         */

        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');

        /*
        $result = DB::table('coas as a')
            ->leftJoin(DB::raw('(select coa_id, sum(amount) as debit from spp_transactions where year(`date`) = "' . $active_year[0] . '" group by coa_id) as b'), 'a.id', '=', 'b.coa_id')
            ->leftJoin(DB::raw('(select coa_id, sum(grand_total) as credit from transactions where year(`date`) = "' . $active_year[0] . '" group by coa_id) as c'), 'a.id', '=', 'c.coa_id')
            ->select('a.name', DB::raw('ifnull(b.debit, 0) as debit'), DB::raw('ifnull(c.credit, 0) as credit'))
            ->get();
        */
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
        ]);
    }
}
