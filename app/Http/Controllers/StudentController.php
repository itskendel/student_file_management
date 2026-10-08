<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function __construct(
        protected StudentService $service_student,
        protected ConfigurationService $service_config,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        try {
            return view('application.student.index');
        } catch (\Throwable $th) {
            //throw $th;

            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $strands = $this->service_config->index_strand();
            $school_years = $this->service_config->index_school_year();
            $grade_levels = $this->service_config->index_grade_level();

            return view('application.student.create', compact('strands', 'school_years', 'grade_levels'));
        } catch (\Throwable $th) {
            //throw $th;

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $student = $this->service_student->store($request);

            DB::commit();

            return redirect()->route('students.show', $student->id)->with('success', 'Student data has been store.');
        } catch (ValidationException $e) {
            DB::rollBack();

            throw $e;
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $student = $this->service_student->show($id);

            return view('application.student.show', compact('student'));
        } catch (\Throwable $th) {
            //throw $th;

            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        try {
            $strands = $this->service_config->index_strand();
            $school_years = $this->service_config->index_school_year();
            $grade_levels = $this->service_config->index_grade_level();

            $student = $this->service_student->show($id);

            return view('application.student.edit', compact('student', 'strands', 'school_years', 'grade_levels'));
        } catch (\Throwable $th) {
            //throw $th;

            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            DB::beginTransaction();

            $student = $this->service_student->update($request, $id);

            DB::commit();

            return redirect()->route('students.show', $student->id)->with('success', 'Student data has been saved.');
        } catch (ValidationException $e) {
            DB::rollBack();

            throw $e;
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            DB::beginTransaction();

            $this->service_student->destroy($id);

            DB::commit();

            return redirect()->route('students.index')->with('success', 'Student data has been deleted.');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to delete student data.');
        }
    }

    public function create_file(Request $request)
    {
        try {
            $file_types = $this->service_config->index_file_type();
            $student = $this->service_student->show($request->student_id);

            return view('application.student.create_file', compact('student', 'file_types'));
        } catch (\Throwable $th) {
            //throw $th;

            return redirect()->back();
        }
    }

    public function store_file(Request $request)
    {
        try {
            $this->service_student->store_file($request);

            return redirect()->route('students.show', $request->student_id);
        } catch (\Throwable $th) {
            //throw $th;

            return redirect()->back();
        }
    }

    public function destroy_file(int $file_id)
    {
        try {
            $this->service_student->destroy_file($file_id);

            return redirect()->route('students.index');
        } catch (\Throwable $th) {
            //throw $th;

            return redirect()->back();
        }
    }
}
