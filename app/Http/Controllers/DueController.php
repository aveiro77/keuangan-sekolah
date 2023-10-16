<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Due;
use App\Models\ActiveYear;
use Inertia\Inertia;

class DueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $data = Due::with('active_year')->where('active_year_id', $active_year->id)->get();
        return Inertia::render('Master/Due', [
            'dues' => $data,
            'period' => $active_year->period,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $active_year = ActiveYear::where('active', 1)->first();
        return Inertia::render('Master/DueCreate', [
            'period' => $active_year->period,
            'active_year_id' => $active_year->id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'total_amount' => 'required',
            'type' => 'required',
            'group' => 'required',
            'active_year_id' => 'required'
        ]);

        Due::create([
            'name' => $request->name,
            'total_amount' => $request->total_amount,
            'type' => $request->type,
            'group' => $request->group,
            'active_year_id' => $request->active_year_id
        ]);

        return redirect()->route('iuran.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Due $due)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $data = Due::find($id);
        return Inertia::render('Master/DueEdit', [
            'period' => $active_year->period,
            'active_year_id' => $active_year->id,
            'due' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Due $due, $id)
    {
        $db = Due::find($id);
        $db->update([
            'name' => $request->name,
            'total_amount' => $request->total_amount,
            'type' => $request->type,
            'group' => $request->group,
            'active_year_id' => $request->active_year_id
        ]);

        return redirect()->route('iuran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $db = Due::find($id);

        if ($db) {
            $db->delete();
        }

        return redirect()->route('iuran.index');
    }
}
