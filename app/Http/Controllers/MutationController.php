<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mutation;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Coa;
use App\Models\ActiveYear;
use Illuminate\Support\Facades\Auth;

class MutationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $data = Mutation::with(['User', 'Coa'])
            ->whereYear('date', $active_year->year)
            ->orderBy('id', 'desc')
            ->when($request->search, function ($query, $search) {
                $query->whereHas('Coa', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%");
                })->orWhere('trn', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Transaction/Mutation', [
            'mutations' => $data,
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
        return Inertia::render('Transaction/MutationCreate', [
            'coas' => $coas,
            'period' => $active_year->period,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;

        //get last number
        $lastTrx = Mutation::whereRaw('MONTH(date) = ?', substr($request->date, 5, 2))->latest()->pluck('trn');
        if (empty($lastTrx[0])) {
            $lastTrx[0] = 'xxx-xxxx-0000';
        }

        //generate trn
        $trn = 'T03-' . substr($request->date, 2, 2) . substr($request->date, 5, 2) . '-' . str_pad((intval(ltrim(substr($lastTrx[0], 9, 4), '0'))) + 1, 4, '0', STR_PAD_LEFT);
        $user = Auth::user()->id;

        $request->validate([
            'date' => 'required',
            'description' => 'required',
            'coa_id' => 'required',
            'coa_id2' => 'required',
            'amount' => 'required',
            'stack' => 'required',
        ]);

        Mutation::create([
            'trn' => $trn,
            'date' => $request->date,
            'description' => $request->description,
            'coa_id' => $request->coa_id,
            'coa_id2' => $request->coa_id2,
            'user_id' => $user,
            'debit' => 0,
            'credit' => $request->amount,
            'stack' => $request->stack,
        ]);

        //inverse
        Mutation::create([
            'trn' => $trn,
            'date' => $request->date,
            'description' => $request->description,
            'coa_id' => $request->coa_id2,
            'coa_id2' => $request->coa_id,
            'user_id' => $user,
            'debit' => $request->amount,
            'credit' => 0,
            'stack' => 2,
        ]);

        return redirect()->route('mutasi.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mutation $mutation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $trx = Mutation::find($id);
        $coas = Coa::where('active_year_id', $active_year->id)->get();
        return Inertia::render('Transaction/MutationEdit', [
            'mutation' => $trx,
            'coas' => $coas,
            'period' => $active_year->period,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mutation $mutation, $id)
    {
        // update stack 1
        $db_stack1 = Mutation::find($id);
        $db_stack1->update([
            'date' => $request->date,
            'description' => $request->description,
            'coa_id' => $request->coa_id,
            'coa_id2' => $request->coa_id2,
            'debit' => 0,
            'credit' => $request->amount,
        ]);


        // update stack 2
        $trn = Mutation::where('id', $id)->pluck('trn');
        $db_stack2 = Mutation::where([
            ['trn', $trn[0]],
            ['stack', 2],
        ]);

        $db_stack2->update([
            'date' => $request->date,
            'description' => $request->description,
            'coa_id' => $request->coa_id2,
            'coa_id2' => $request->coa_id,
            'debit' => $request->amount,
            'credit' => 0,
        ]);

        return redirect()->route('mutasi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($trn)
    {
        $db = DB::table('mutations')->where('trn', $trn);

        if ($db) {
            $db->delete();
        }

        return redirect()->route('mutasi.index');
    }
}
