<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StrandController extends Controller
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
            return view('application.strand.index');
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
            return view('application.strand.create');
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

            $strand = $this->service_config->store_strand($request);

            DB::commit();

            return redirect()->route('strands.show', $strand->id)->with('success', 'Strand data has been stored.');
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
            $strand = $this->service_config->show_strand($id);

            return view('application.strand.show', compact('strand'));
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
            $strand = $this->service_config->show_strand($id);

            return view('application.strand.edit', compact('strand'));
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

            $this->service_config->update_strand($request, $id);

            DB::commit();

            return redirect()->route('strands.show', $id)->with('success', 'Strand data has been saved.');
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

            $this->service_config->destroy_strand($id);

            DB::commit();

            return redirect()->route('strands.index')->with('success', 'Strand data has been deleted.');
        } catch (\Throwable $th) {
            // throw $th;

            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to delete strand data.');
        }
    }
}
