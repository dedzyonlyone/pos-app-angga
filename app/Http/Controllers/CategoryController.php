<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [new Middleware('role:admin')];
    }

    public function index(Request $request)
    {
        $q = $request->get('search');
        $categories = Category::withCount('products')
            ->when($q, fn($x) => $x->where('name', 'like', "%$q%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('categories', 'q'));
    }

    public function create()
    {
        return view('categories.form', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah dipakai.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'description.max' => 'Deskripsi maksimal 255 karakter.',
        ]);

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah dipakai.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'description.max' => 'Deskripsi maksimal 255 karakter.',
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', "Kategori masih dipakai oleh {$category->products()->count()} produk.");
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}