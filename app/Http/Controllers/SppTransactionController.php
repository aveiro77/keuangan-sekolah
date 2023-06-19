<?php

namespace App\Http\Controllers;

use App\Models\Spp_transaction;
use App\Models\Student;
use App\Models\Coa;
use App\Models\Due;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class SppTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $active_year = DB::table('active_year')->where('active', 1)->pluck('year');
        $trx = Spp_transaction::with(['Student', 'Coa', 'Due'])
            ->orderBy('id', 'desc')
            ->whereYear('date', $active_year[0])
            ->when($request->search, function ($query, $search) {
                $query->whereHas('Student', function ($subQuery) use ($search) {
                    $subQuery->where('nisn', 'like', "%{$search}%")
                        ->orWhere('fullname', 'like', "%{$search}%");
                })->orWhere('trn', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();


        return Inertia::render('Transaction/DueSpp', [
            'transactions' => $trx,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');
        $students = Student::where('year', $active_year[0])->get();
        $coas = Coa::where('year', $active_year[0])->get();
        $dues = Due::where('year', $active_year[0])->get();

        $trx = Spp_transaction::with(['Student', 'Coa', 'Due'])->orderBy('id', 'desc')->when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('Student', function ($subQuery) use ($search) {
                    $subQuery->where('nisn', 'like', '%' . $search . '%')->orWhere('fullname', 'like', '%' . $search . '%');
                });
                $q->orWhere('trn', 'like', '%' . $search . '%');
            });
        })->paginate(10)->withQueryString();

        return Inertia::render('Transaction/DueSppCreate', [
            'students' => $students,
            'coas' => $coas,
            'dues' => $dues,
            'transactions' => $trx,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #return $request;

        //get last number
        $lastTrx = Spp_transaction::whereRaw('MONTH(date) = ?', substr($request->date, 5, 2))->latest()->pluck('trn');
        if (empty($lastTrx[0])) {
            $lastTrx[0] = 'xxx-xxxx-0000';
        }

        //generate trn
        $trn = 'T01-' . substr($request->date, 2, 2) . substr($request->date, 5, 2) . '-' . str_pad((intval(ltrim(substr($lastTrx[0], 9, 4), '0'))) + 1, 4, '0', STR_PAD_LEFT);

        //$trn = Spp_transaction::latest()->pluck('id');
        $user = Auth::user()->id;
        $request->validate([
            'student_id' => 'required',
            'due_id' => 'required',
            'coa_id' => 'required',
            'date' => 'required',
            'description' => 'required',
            'total_amount' => 'required',
        ]);

        Spp_transaction::create([
            'trn' => $trn,
            'user_id' => $user,
            'student_id' => $request->student_id,
            'due_id' => $request->due_id,
            'coa_id' => $request->coa_id,
            'date' => $request->date,
            'description' => $request->description,
            'amount' => $request->total_amount,
        ]);

        return redirect()->route('spp.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Spp_transaction $spp_transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $trx = Spp_transaction::find($id);
        $students = Student::all();
        $dues = Due::all();
        $coas = Coa::all();
        return Inertia::render('Transaction/DueSppEdit', [
            'trans' => $trx,
            'students' => $students,
            'dues' => $dues,
            'coas' => $coas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Spp_transaction $spp_transaction, $id)
    {
        $db = Spp_transaction::find($id);
        $db->update([
            'student_id' => $request->student_id,
            'coa_id' => $request->coa_id,
            'due_id' => $request->due_id,
            'amount' => $request->total_amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('spp.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $db = Spp_transaction::find($id);

        if ($db) {
            $db->delete();
        }

        return redirect()->route('spp.index');
    }
}
