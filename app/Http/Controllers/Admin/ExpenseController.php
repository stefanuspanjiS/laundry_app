<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expense::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('kategori', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $pengeluaran = $query
            ->latest('tanggal')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $kategori = Expense::query()
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $totalPengeluaran = (clone $query)->sum('jumlah');

        return view('admin.expenses.index', compact(
            'pengeluaran',
            'kategori',
            'totalPengeluaran'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'tanggal' => ['required', 'date'],
        'kategori' => ['required', 'string', 'max:100'],
        'keterangan' => ['nullable', 'string'],
        'jumlah' => ['required', 'numeric', 'min:0'],
    ]);

    Expense::create($validated);

    return redirect()
        ->route('admin.expenses.index')
        ->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(expense $expense)
    {
        return view('admin.expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, expense $expense)
    {
        $validated = $request->validate([
        'tanggal' => ['required', 'date'],
        'kategori' => ['required', 'string', 'max:100'],
        'keterangan' => ['nullable', 'string'],
        'jumlah' => ['required', 'numeric', 'min:0'],
    ]);

    $expense->update($validated);

    return redirect()
        ->route('admin.expenses.index')
        ->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
