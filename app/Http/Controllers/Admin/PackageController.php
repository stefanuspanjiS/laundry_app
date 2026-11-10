<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    //Menampilkan daftar paket
    public function index(Request $request)
    {
        $query = Package::query();

        // Search berdasarkan nama paket
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nama_paket', 'like', "%{$search}%");
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $packages = $query->latest()->get();

        return view('admin.packages.index', compact('packages'));
    }

    // Form tambah paket
    public function create()
    {
        return view('admin.packages.create');
    }

    // Simpan paket baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => ['required', 'string', 'max:255'],
            'harga_per_kg' => ['required', 'numeric', 'min:0'],
            'estimasi_hari' => ['required', 'integer', 'min:1'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ], [
            'nama_paket.required' => 'Nama paket wajib diisi.',
            'harga_per_kg.required' => 'Harga per kg wajib diisi.',
            'harga_per_kg.numeric' => 'Harga harus berupa angka.',
            'harga_per_kg.min' => 'Harga tidak boleh kurang dari 0.',
            'estimasi_hari.required' => 'Estimasi hari wajib diisi.',
            'estimasi_hari.integer' => 'Estimasi hari harus berupa angka.',
            'estimasi_hari.min' => 'Estimasi minimal 1 hari.',
            'status.required' => 'Status paket wajib dipilih.',
        ]);

        Package::create($validated);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket laundry berhasil ditambahkan.');
    }

    // Form edit paket
    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    // Update paket
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'nama_paket' => ['required', 'string', 'max:255'],
            'harga_per_kg' => ['required', 'numeric', 'min:0'],
            'estimasi_hari' => ['required', 'integer', 'min:1'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ], [
            'nama_paket.required' => 'Nama paket wajib diisi.',
            'harga_per_kg.required' => 'Harga per kg wajib diisi.',
            'harga_per_kg.numeric' => 'Harga harus berupa angka.',
            'harga_per_kg.min' => 'Harga tidak boleh kurang dari 0.',
            'estimasi_hari.required' => 'Estimasi hari wajib diisi.',
            'estimasi_hari.integer' => 'Estimasi hari harus berupa angka.',
            'estimasi_hari.min' => 'Estimasi minimal 1 hari.',
            'status.required' => 'Status paket wajib dipilih.',
        ]);

        $package->update($validated);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket laundry berhasil diperbarui.');
    }

    // Hapus paket
    public function destroy(Package $package)
    {
        // Cek apakah paket sudah digunakan dalam transaksi
        if ($package->transactionDetails()->exists()) {
            return back()->with(
                'error',
                'Paket tidak dapat dihapus karena sudah digunakan dalam transaksi.'
            );
        }

        $package->delete();

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket laundry berhasil dihapus.');
    }
}
