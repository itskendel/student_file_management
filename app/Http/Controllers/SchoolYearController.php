<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SchoolYearController extends Controller
{
    public function __construct(
        protected ConfigurationService $service_config,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('application.school_year.index');
        } catch (\Throwable $th) {
            // throw $th;

            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('application.school_year.create');
        } catch (\Throwable $th) {
            // throw $th;

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

            $school_year = $this->service_config->store_school_year($request);

            DB::commit();

            return redirect()->route('school_years.show', $school_year->id)->with('success', 'School year data has been stored.');
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
            $school_year = $this->service_config->show_school_year($id);

            return view('application.school_year.show', compact('school_year'));
        } catch (\Throwable $th) {
            // throw $th;

            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        try {
            $school_year = $this->service_config->show_school_year($id);

            return view('application.school_year.edit', compact('school_year'));
        } catch (\Throwable $th) {
            // throw $th;

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

            $this->service_config->update_school_year($request, $id);

            DB::commit();

            return redirect()->route('school_years.show', $id)->with('success', 'School year data has been saved.');
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

            $this->service_config->destroy_school_year($id);

            DB::commit();

            return redirect()->route('school_years.index')->with('success', 'School year data has been deleted.');
        } catch (\Throwable $th) {
            // throw $th;

            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to delete school year data.');
        }
    }
}
