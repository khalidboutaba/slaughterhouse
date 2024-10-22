<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Controllers\Controller; // Ensure this is imported
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:customer-list|customer-show|customer-create|customer-edit|customer-delete', ['only' => ['index']]);
         $this->middleware('permission:customer-show', ['only' => ['show']]);
         $this->middleware('permission:customer-create', ['only' => ['create','store']]);
         $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'note' => 'nullable|string',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'تم إضافة العميل بنجاح!');
    }

    public function show(Customer $customer)
    {
        $quantityMap = [
            '1/4' => 0.25,
            '1/2' => 0.5,
            '3/4' => 0.75,
            '1' => 1,
        ];
        $customer->load('sales', 'payments');
        return view('customers.show', compact('customer','quantityMap'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'تم تحديث العميل بنجاح!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'تم حذف العميل بنجاح!');
    }
}