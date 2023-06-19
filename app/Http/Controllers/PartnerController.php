<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Partner::when($request->search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')->orWhere('address', 'like', '%' . $search . '%');
        })->paginate(8)->withQueryString();
        return Inertia::render('Master/Partner', [
            'partners' => $data,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/PartnerCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'address' => 'required',
        ]);

        Partner::create([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('rekanan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Partner::find($id);
        return Inertia::render('Master/PartnerEdit', [
            'partner' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner, $id)
    {
        $db = Partner::find($id);
        $db->update([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('rekanan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner, $id)
    {
        $db = Partner::find($id);

        if ($db) {
            $db->delete();
        }

        return redirect()->route('rekanan.index');
    }
}
