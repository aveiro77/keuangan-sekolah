<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ActiveYear;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ConfigController extends Controller
{
    public function periods()
    {
        $activeYear = ActiveYear::where('active', 1)->first();
        $data = ActiveYear::all();
        return Inertia::render('Config/setupPeriod', [
            'periods' => $data,
            'period' => $activeYear->period,
        ]);
    }

    public function createPeriod(Request $request)
    {
        //return $request;

        $latest = ActiveYear::latest('id')->first();
        ActiveYear::create([
            //'year' => $latest->year + 1,
            'year' => substr($request->newPeriod, 5, 4),
            'period' => $request->newPeriod,
            'active' => 0,
        ]);
        $data = ActiveYear::all();
        return redirect()->route('konfigurasi.periode-laporan')->with(['periods' => $data]);
    }

    public function updatePeriod(Request $request, $id)
    {
        $data = ActiveYear::all();

        foreach ($data as $activeYear) {
            $activeYear->update([
                'active' => 0,
            ]);
        }

        $db = ActiveYear::find($id);
        $db->update([
            'active' => $request->active,
        ]);

        return redirect()->route('konfigurasi.periode-laporan')->with(['periods' => $data]);
    }

    public function masters()
    {
        $activeYear = ActiveYear::where('active', 1)->first();
        return Inertia::render('Config/setupMaster', [
            'period' => $activeYear->period,
        ]);
    }

    public function procMasterCoas(Request $request)
    {
        try {
            DB::statement('CALL InsertIntoCoas()');

            // Tindakan yang diambil jika prosedur berhasil
            return response()->json([
                'messageCoa' => 'master rekening berhasil dijalankan',
                'status' => 0
            ]);
        } catch (QueryException $e) {
            // Tindakan yang diambil jika terjadi error
            $errorMessage = $e->getMessage();

            // Lakukan logging, tangani error, dll.
            return response()->json([
                'messageCoa' => 'master rekening GAGAL!',
                'status' => 0
            ]);
        }

        return response()->json([
            'message' => 'Procedure master rekening berhasil dijalankan',
            'status' => 0
        ]);
    }

    public function procMasterStudents(Request $request)
    {
        try {
            DB::statement('CALL UpdateStudents()');

            // Tindakan yang diambil jika prosedur berhasil
            return response()->json([
                'messageStudents' => 'data rombel secara masal berhasil dijalankan',
                'status' => 0
            ]);
        } catch (QueryException $e) {
            // Tindakan yang diambil jika terjadi error
            $errorMessage = $e->getMessage();

            // Lakukan logging, tangani error, dll.
            return response()->json([
                'messageStudents' => 'data rombel GAGAL!',
                'status' => 0
            ]);
        }

        return response()->json([
            'message' => 'data rombel secara masal berhasil dijalankan',
            'status' => 0
        ]);
    }

    public function procMasterDues(Request $request)
    {
        try {
            DB::statement('CALL InsertIntoDues()');

            // Tindakan yang diambil jika prosedur berhasil
            return response()->json([
                'messageDues' => 'data rombel secara masal berhasil dijalankan',
                'status' => 0
            ]);
        } catch (QueryException $e) {
            // Tindakan yang diambil jika terjadi error
            $errorMessage = $e->getMessage();

            // Lakukan logging, tangani error, dll.
            return response()->json([
                'messageDues' => 'data iuran GAGAL!',
                'status' => 0
            ]);
        }

        return response()->json([
            'message' => 'Procedure master iuran berhasil dijalankan',
            'status' => 0
        ]);
    }

    public function studentsStats(Request $request)
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $data = Student::with('active_year')
            ->when($request->search, function ($query, $search) {
                $query->where('fullname', 'like', '%' . $search . '%')->orWhere('nisn', 'like', '%' . $search . '%');
            })
            ->paginate(8)->withQueryString();

        return Inertia::render('Config/setupStudents', [
            'students' => $data,
            'filters' => $request->only('search'),
            'period' => $active_year->period,
        ]);
        // $activeYear = ActiveYear::where('active', 1)->first();
        // $students = Student::all();
        // return Inertia::render('Config/setupStudents', [
        //     'period' => $activeYear->period,
        //     'students' => $students,
        // ]);
    }

    public function studentStatsEdit($id)
    {
        $active_year = ActiveYear::where('active', 1)->first();
        $data = Student::find($id);
        return Inertia::render('Config/setupStudentsEdit', [
            'student' => $data,
            'period' => $active_year->period,
        ]);
    }

    public function studentStatsUpdate(Request $request, $id)
    {
        // return $id;
        $db = Student::find($id);
        $db->update([
            'temp_status' => $request->temp_status,
        ]);

        return redirect()->route('konfigurasi.status-siswa');
    }
}
