<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [ new Middleware('role:admin') ];
    }

    public function index()
    {
        $search = request('search');
        $categories = Category::withCount('products')
            ->when($search, fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->latest()->paginate(10)->withQueryString();
        return view('categories.index', compact('categories'));
    }

    public function create() { return view('categories.create'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $category = Category::create($validated);
        ActivityLogger::log('create', 'categories', $category->id, null, $validated);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category) { return view('categories.edit', compact('category')); }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $oldData = $category->toArray();
        $category->update($validated);
        ActivityLogger::log('update', 'categories', $category->id, $oldData, $validated);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) return redirect()->route('categories.index')->with('error', 'Kategori tidak bisa dihapus karena masih dipakai.');
        ActivityLogger::log('delete', 'categories', $category->id, $category->toArray(), null);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}