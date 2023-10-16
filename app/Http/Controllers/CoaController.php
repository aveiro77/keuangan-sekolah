<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Coa;
use App\Models\ActiveYear;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Inertia\Inertia;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $data = Coa::with('active_year')->where('active_year_id', $active_year->id)->get();
        return Inertia::render('Master/Coa', [
            'coas' => $data,
            'period' => $active_year->period
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        return Inertia::render('Master/CoaCreate', [
            'active_year_id' => $active_year->id,
            'period' => $active_year->period,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request->all();
        $request->validate([
            'code' => 'required|unique:coas|max:25',
            'name' => 'required',
            'active_year_id' => 'required',
            'initial_balance' => 'required'
        ]);

        Coa::create([
            'code' => $request->code,
            'name' => $request->name,
            'active_year_id' => $request->active_year_id,
            'initial_balance' => $request->initial_balance,
            ''
        ]);

        return redirect()->route('rekening.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coa $coa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Coa::with('active_year')->find($id);
        return Inertia::render('Master/CoaEdit', [
            'coa' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $db = Coa::find($id);
        $db->update([
            'code' => $request->code,
            'name' => $request->name,
            'initial_balance' => $request->initial_balance
        ]);

        return redirect()->route('rekening.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $db = Coa::find($id);

        if ($db) {
            $db->delete();
        }

        return redirect()->route('rekening.index');
    }
}
