<?php

namespace App\Http\Controllers;


use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:program-studi-list|program-studi-create|program-studi-edit|program-studi-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:program-studi-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:program-studi-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:program-studi-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $programStudis = ProgramStudi::latest()->paginate(5);
        return view('program-studi.index', compact('programStudis'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('program-studi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
        ]);

        ProgramStudi::create($request->all());

        return redirect()->route('program-studi.index')
            ->with('success', 'program-studi created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\program-studi  $program-studi
     * @return \Illuminate\Http\Response
     */
    public function show(progrProgramStudi $programStudi): View
    {
        return view('program-studi.show', compact('programStudi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\program-studi  $program-studi
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramStudi $programStudi): View
    {
        return view('program-studi.edit', compact('programStudi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\program-studi  $program-studi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramStudi $programStudi): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
        ]);

        $programStudi->update($request->all());

        return redirect()->route('program-studi.index')
            ->with('success', 'program-studi updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\program-studi  $program-studi
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramStudi $programStudi): RedirectResponse
    {
        $programStudi->delete();

        return redirect()->route('program-studi.index')
            ->with('success', 'program-studi deleted successfully');
    }
}
