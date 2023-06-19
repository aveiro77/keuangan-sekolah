<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Coa;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $active_year = DB::table('active_year')->where('active', 1)->pluck('year');
        $data = Transaction::with(['User', 'Coa', 'Partner'])
            ->orderBy('id', 'desc')
            ->whereYear('date', $active_year[0])
            ->when($request->search, function ($query, $search) {
                $query->whereHas('Coa', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%");
                })->orWhere('trn', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();


        return Inertia::render('Transaction/Opr', [
            'transactions' => $data,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $active_year = DB::table('active_year')->where('active', 1)->pluck('year');
        $partners = Partner::all();
        $coas = Coa::where('year', $active_year[0])->get();
        return Inertia::render('Transaction/OprCreate', [
            'partners' => $partners,
            'coas' => $coas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //get last number
        $lastTrx = Transaction::whereRaw('MONTH(date) = ?', substr($request->date, 5, 2))->latest()->pluck('trn');
        if (empty($lastTrx[0])) {
            $lastTrx[0] = 'xxx-xxxx-0000';
        }

        //generate trn
        $trn = 'T02-' . substr($request->date, 2, 2) . substr($request->date, 5, 2) . '-' . str_pad((intval(ltrim(substr($lastTrx[0], 9, 4), '0'))) + 1, 4, '0', STR_PAD_LEFT);

        $user = Auth::user()->id;
        $request->validate([
            'date' => 'required',
            'description' => 'required',
            'partner_id' => 'required',
            'coa_id' => 'required',
            'grand_total' => 'required',
        ]);

        Transaction::create([
            'trn' => $trn,
            'date' => $request->date,
            'description' => $request->description,
            'partner_id' => $request->partner_id,
            'coa_id' => $request->coa_id,
            'user_id' => $user,
            'sub_total' => $request->grand_total,
            'tax' => 'NONE',
            'ppn' => 0,
            'grand_total' => $request->grand_total,
        ]);
        return redirect()->route('opr.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $trx = Transaction::find($id);
        $partners = Partner::all();
        $active_year = DB::table('active_year')->where('active', 1)->pluck('year');
        $coas = Coa::where('year', $active_year[0])->get();
        return Inertia::render('Transaction/OprEdit', [
            'transaction' => $trx,
            'partners' => $partners,
            'coas' => $coas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction, $id)
    {
        $db = Transaction::find($id);
        $db->update([
            'date' => $request->date,
            'description' => $request->description,
            'partner_id' => $request->partner_id,
            'coa_id' => $request->coa_id,
            'sub_total' => $request->grand_total,
            'tax' => 'NONE',
            'ppn' => 0,
            'grand_total' => $request->grand_total,
        ]);

        return redirect()->route('opr.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $db = Transaction::find($id);

        if ($db) {
            $db->delete();
        }

        return redirect()->route('opr.index');
    }
}
