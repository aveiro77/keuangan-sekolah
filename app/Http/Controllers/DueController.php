<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateDueRequest;
use App\Models\Due;
use Inertia\Inertia;

class DueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');
        $data = Due::where('year', $active_year)->get();
        return Inertia::render('Master/Due', [
            'dues' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/DueCreate');
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
            'year' => 'required'
        ]);

        Due::create([
            'name' => $request->name,
            'total_amount' => $request->total_amount,
            'type' => $request->type,
            'group' => $request->group,
            'year' => $request->year
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
        $data = Due::find($id);
        return Inertia::render('Master/DueEdit', [
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
            'year' => $request->year
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
