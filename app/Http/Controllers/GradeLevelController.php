<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GradeLevelController extends Controller
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
            return view('application.grade_level.index');
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
            return view('application.grade_level.create');
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

            $grade_level = $this->service_config->store_grade_level($request);

            DB::commit();

            return redirect()->route('grade_levels.show', $grade_level->id)->with('success', 'Grade level data has been stored.');
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
            $grade_level = $this->service_config->show_grade_level($id);

            return view('application.grade_level.show', compact('grade_level'));
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
            $grade_level = $this->service_config->show_grade_level($id);

            return view('application.grade_level.edit', compact('grade_level'));
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

            $this->service_config->update_grade_level($request, $id);

            DB::commit();

            return redirect()->route('grade_levels.show', $id)->with('success', 'Grade level data has been saved.');
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

            $this->service_config->destroy_grade_level($id);

            DB::commit();

            return redirect()->route('grade_levels.index')->with('success', 'Grade level data has been deleted.');
        } catch (\Throwable $th) {
            // throw $th;

            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to delete grade level data.');
        }
    }
}
