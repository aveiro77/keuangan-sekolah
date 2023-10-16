<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Models\Income;
use App\Models\Coa;
use App\Models\ActiveYear;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $data = Income::with(['User', 'Coa'])
            ->orderBy('id', 'desc')
            ->whereYear('date', $active_year->year)
            ->when($request->search, function ($query, $search) {
                $query->whereHas('Coa', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%");
                })->orWhere('trn', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%")->orWhere('source', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();


        return Inertia::render('Transaction/Income', [
            'incomes' => $data,
            'filters' => $request->only('search'),
            'period' => $active_year->period,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $coas = Coa::where('active_year_id', $active_year->id)->get();
        return Inertia::render('Transaction/IncomeCreate', [
            'coas' => $coas,
            'period' => $active_year->period,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //get last number
        $lastTrx = Income::whereRaw('MONTH(date) = ?', substr($request->date, 5, 2))->latest()->pluck('trn');
        if (empty($lastTrx[0])) {
            $lastTrx[0] = 'xxx-xxxx-0000';
        }

        //generate trn
        $trn = 'T04-' . substr($request->date, 2, 2) . substr($request->date, 5, 2) . '-' . str_pad((intval(ltrim(substr($lastTrx[0], 9, 4), '0'))) + 1, 4, '0', STR_PAD_LEFT);

        $user = Auth::user()->id;
        $request->validate([
            'date' => 'required',
            'source' => 'required',
            'description' => 'required',
            'coa_id' => 'required',
            'amount' => 'required',
        ]);

        Income::create([
            'trn' => $trn,
            'date' => $request->date,
            'description' => $request->description,
            'coa_id' => $request->coa_id,
            'user_id' => $user,
            'source' => $request->source,
            'amount' => $request->amount,
        ]);
        return redirect()->route('pemasukan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $trx = Income::find($id);
        $active_year = ActiveYear::where('active', 1)->first();
        $coas = Coa::where('active_year_id', $active_year->id)->get();
        return Inertia::render('Transaction/IncomeEdit', [
            'income' => $trx,
            'coas' => $coas,
            'period' => $active_year->period,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income, $id)
    {
        $db = Income::find($id);
        $db->update([
            'source' => $request->source,
            'date' => $request->date,
            'description' => $request->description,
            'coa_id' => $request->coa_id,
            'amount' => $request->amount,
        ]);

        return redirect()->route('pemasukan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $db = Income::find($id);

        if ($db) {
            $db->delete();
        }

        return redirect()->route('pemasukan.index');
    }
}
