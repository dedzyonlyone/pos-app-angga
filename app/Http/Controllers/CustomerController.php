<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

class CustomerController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [new Middleware('role:admin', only: ['destroy'])];
    }

    public function index(Request $request)
    {
        $q = $request->search;

        $customers = Customer::withCount('sales')
            ->when($q, function ($x) use ($q) {
                $x->where(function ($y) use ($q) {
                    $y->where('name', 'like', "%$q%")
                      ->orWhere('phone', 'like', "%$q%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('customers.index', compact('customers', 'q'));
    }

    public function create()
    {
        return view('customers.form', ['customer' => new Customer()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['sales' => fn($q) => $q->latest('sale_date')->limit(20)]);

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.form', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($this->validateData($request, $customer->id));

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        // Relasi di migration pakai nullOnDelete, jadi riwayat transaksi aman
        $customer->delete();

        return back()->with('success', 'Pelanggan dihapus. Riwayat transaksi tetap tersimpan.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^08[0-9]{8,11}$/',
                Rule::unique('customers', 'phone')->ignore($ignoreId)],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required' => 'Nama pelanggan wajib diisi.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'phone.regex' => 'Nomor HP harus diawali 08 dan terdiri dari 10–13 digit.',
            'phone.unique' => 'Nomor HP sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
            'address.max' => 'Alamat maksimal 500 karakter.',
        ]);
    }
}