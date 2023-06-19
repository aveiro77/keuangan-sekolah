<?php

namespace App\Http\Controllers;

use App\Models\Student;
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
        $active_year = DB::table('active_year')->where('active', '=', '1')->pluck('year');
        $data = Student::when($request->search, function ($query, $search) {
            $query->where('fullname', 'like', '%' . $search . '%')->orWhere('nisn', 'like', '%' . $search . '%');
        })
            ->where('year', $active_year)
            ->paginate(8)->withQueryString();
        return Inertia::render('Master/Student', [
            'students' => $data,
            'filters' => $request->only('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/StudentCreate');
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
            'year' => 'required'
        ]);

        Student::create([
            'nisn' => $request->nisn,
            'fullname' => $request->fullname,
            'group' => $request->group,
            'year' => $request->year
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
        $data = Student::find($id);
        return Inertia::render('Master/StudentEdit', [
            'student' => $data
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
