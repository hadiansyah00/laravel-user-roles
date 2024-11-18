<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MahasiswaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:mahasiswa-list|mahasiswa-create|mahasiswa-edit|mahasiswa-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:mahasiswa-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:mahasiswa-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:mahasiswa-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $mahasiswa = Mahasiswa::with('programStudi')->paginate(10);
        return view('mahasiswa.index', compact('mahasiswa'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create(): View
    {
        $programStudi = ProgramStudi::all();
        return view('mahasiswa.create', compact('programStudi'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:mahasiswa,email',
            'password' => 'required|min:8',
            'program_studi_id' => 'required|exists:program_studi,program_studi_id',
            'nim' => 'required|unique:mahasiswa,nim',
        ]);

        Mahasiswa::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'program_studi_id' => $request->program_studi_id,
            'nim' => $request->nim,
        ]);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa created successfully.');
    }

    public function show(Mahasiswa $mahasiswa): View
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        $programStudi = ProgramStudi::all();
        return view('mahasiswa.edit', compact('mahasiswa', 'programStudi'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:mahasiswa,email,' . $mahasiswa->mahasiswa_id . ',mahasiswa_id',
            'program_studi_id' => 'required|exists:program_studi,program_studi_id',
            'nim' => 'required|unique:mahasiswa,nim,' . $mahasiswa->mahasiswa_id . ',mahasiswa_id',
        ]);

        $mahasiswa->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $mahasiswa->password,
            'program_studi_id' => $request->program_studi_id,
            'nim' => $request->nim,
        ]);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa updated successfully.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa deleted successfully.');
    }
}