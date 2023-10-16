<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ActiveYear;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $data = Student::with('active_year')
            ->when($request->search, function ($query, $search) {
                $query->where('fullname', 'like', '%' . $search . '%')->orWhere('nisn', 'like', '%' . $search . '%');
            })
            ->whereHas('active_year', function ($query) {
                $query->where('active', 1);
            })
            ->paginate(8)->withQueryString();

        return Inertia::render('Master/Student', [
            'students' => $data,
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
        return Inertia::render('Master/StudentCreate', [
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
            'nisn' => 'required|unique:students|max:25',
            'fullname' => 'required|max:128',
            'group' => 'required',
            'active_year_id' => 'required'
        ]);

        Student::create([
            'nisn' => $request->nisn,
            'fullname' => $request->fullname,
            'group' => $request->group,
            'active_year_id' => $request->active_year_id,
        ]);

        return redirect()->route('siswa.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Student::with('active_year')->find($id);
        return Inertia::render('Master/StudentEdit', [
            'student' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student, $id)
    {
        $db = Student::find($id);
        $db->update([
            'nisn' => $request->nisn,
            'fullname' => $request->fullname,
            'group' => $request->group,
            'year' => $request->year,
        ]);

        return redirect()->route('siswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $db = Student::find($id);

        if ($db) {
            $db->delete();
        }

        return redirect()->route('siswa.index');
    }
}
