<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Coa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');
        $data = Coa::where('year', $active_year)->get();
        return Inertia::render('Master/Coa', [
            'coas' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/CoaCreate');
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
            'year' => 'required'
        ]);

        Coa::create([
            'code' => $request->code,
            'name' => $request->name,
            'year' => $request->year
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
        $data = Coa::find($id);
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
            'tcode' => $request->tcode,
            'name' => $request->name,
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
