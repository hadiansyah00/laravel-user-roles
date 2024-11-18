<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MatakuliahController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:matakuliah-list|matakuliah-create|matakuliah-edit|matakuliah-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:matakuliah-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:matakuliah-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:matakuliah-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $matakuliah = Matakuliah::with('programStudi')->paginate(10);
        return view('matakuliah.index', compact('matakuliah'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create(): View
    {
        $programStudi = ProgramStudi::all();
        return view('matakuliah.create', compact('programStudi'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:matakuliah,code',
            'program_studi_id' => 'required|exists:program_studi,program_studi_id',
            'semester' => 'required|integer|min:1',
        ]);

        Matakuliah::create([
            'name' => $request->name,
            'code' => $request->code,
            'program_studi_id' => $request->program_studi_id,
            'semester' => $request->semester,
        ]);

        return redirect()->route('matakuliah.index')
            ->with('success', 'Mata kuliah created successfully.');
    }

    public function show(Matakuliah $matakuliah): View
    {
        return view('matakuliah.show', compact('matakuliah'));
    }

    public function edit(Matakuliah $matakuliah): View
    {
        $programStudi = ProgramStudi::all();
        return view('matakuliah.edit', compact('matakuliah', 'programStudi'));
    }

    public function update(Request $request, Matakuliah $matakuliah): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:matakuliah,code,' . $matakuliah->matakuliah_id . ',matakuliah_id',
            'program_studi_id' => 'required',
            'semester' => 'required|integer|min:1',
        ]);

        $matakuliah->update([
            'name' => $request->name,
            'code' => $request->code,
            'program_studi_id' => $request->program_studi_id,
            'semester' => $request->semester,
        ]);

        return redirect()->route('matakuliah.index')
            ->with('success', 'Mata kuliah updated successfully.');
    }

    public function destroy(Matakuliah $matakuliah): RedirectResponse
    {
        $matakuliah->delete();

        return redirect()->route('matakuliah.index')
            ->with('success', 'Mata kuliah deleted successfully.');
    }
}