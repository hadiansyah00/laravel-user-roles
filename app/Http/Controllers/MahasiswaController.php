<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\View\View;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Imports\MahasiswaImport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;

use Yajra\DataTables\DataTables;
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
            'password' => bcrypt($request->password),
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

    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048', // Validasi file Excel
        ]);

        try {
            Excel::import(new MahasiswaImport, $request->file('file'));

            return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->route('admin.mahasiswa.index')
            ->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $filePath = public_path('templates/template_mahasiswa.xlsx');
        $fileName = 'template_mahasiswa.xlsx';

        if (file_exists($filePath)) {
            return response()->download($filePath, $fileName);
        }

        return redirect()->back()->with('error', 'File template tidak ditemukan.');
    }

    public function getMahasiswa()
    {
        $mahasiswa = Mahasiswa::with('programStudi')->select('mahasiswa.*');

        return DataTables::of($mahasiswa)
            ->addIndexColumn()
            ->addColumn('program_studi', fn($row) => $row->programStudi->name ?? '-')
            ->addColumn('action', fn($row) => $this->getActionButtons($row))
            ->rawColumns(['action'])
            ->make(true);
    }

    private function getActionButtons($row)
    {
        $editButton = '<a href="' . route('admin.mahasiswa.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
        $deleteButton = $this->getDeleteButton($row->id);

        return $editButton . ' ' . $deleteButton;
    }

    private function getDeleteButton($id)
    {
        return '<form action="' . route('admin.mahasiswa.destroy', $id) . '" method="POST" style="display:inline;">
                ' . csrf_field() . method_field('DELETE') . '
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
            </form>';
    }
}