<?php

namespace App\Http\Controllers;


use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProgramStudiController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:program-studi-list|program-studi-create|program-studi-edit|program-studi-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:program-studi-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:program-studi-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:program-studi-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $programStudis = ProgramStudi::latest()->paginate(5);
        return view('program-studi.index', compact('programStudis'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function create(): View
    {
        return view('program-studi.create');
    }


    public function store(Request $request): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
        ]);

        ProgramStudi::create($request->all());

        return redirect()->route('program-studi.index')
            ->with('success', 'program-studi created successfully.');
    }


    public function show(progrProgramStudi $programStudi): View
    {
        return view('program-studi.show', compact('programStudi'));
    }


    public function edit(ProgramStudi $programStudi): View
    {
        return view('program-studi.edit', compact('programStudi'));
    }


    public function update(Request $request, ProgramStudi $programStudi): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
        ]);

        $programStudi->update($request->all());

        return redirect()->route('program-studi.index')
            ->with('success', 'program-studi updated successfully');
    }


    public function destroy(ProgramStudi $programStudi): RedirectResponse
    {
        $programStudi->delete();

        return redirect()->route('program-studi.index')
            ->with('success', 'program-studi deleted successfully');
    }
}
