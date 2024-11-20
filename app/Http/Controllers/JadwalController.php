<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:jadwal-list|jadwal-create|jadwal-edit|jadwal-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:jadwal-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:jadwal-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:jadwal-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $jadwal = Jadwal::with('mataKuliah')->paginate(10);

        return view('jadwal.index', compact('jadwal'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create(): View
    {
        $matakuliah = Matakuliah::all();

        return view('jadwal.create', compact('matakuliah'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'matakuliah_id' => 'required|exists:matakuliah,matakuliah_id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'required|string|max:100',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal created successfully.');
    }

    public function show(Jadwal $jadwal): View
    {
        return view('jadwal.show', compact('jadwal'));
    }

    public function edit(Jadwal $jadwal): View
    {
        $matakuliah = Matakuliah::all();

        return view('jadwal.edit', compact('jadwal', 'matakuliah'));
    }

    public function update(Request $request, Jadwal $jadwal): RedirectResponse
    {
        $request->validate([
            'matakuliah_id' => 'required|exists:matakuliah,matakuliah_id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'required|string|max:100',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal updated successfully.');
    }

    public function destroy(Jadwal $jadwal): RedirectResponse
    {
        $jadwal->delete();

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal deleted successfully.');
    }
}