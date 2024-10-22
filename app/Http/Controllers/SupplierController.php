<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SupplierController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:supplier-list|supplier-show|supplier-create|supplier-edit|supplier-delete', ['only' => ['index']]);
         $this->middleware('permission:supplier-show', ['only' => ['show']]);
         $this->middleware('permission:supplier-create', ['only' => ['create','store']]);
         $this->middleware('permission:supplier-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')->with('success', 'تم إضافة المورد بنجاح!');
    }

    public function show(Supplier $supplier)
    {
        // Paginate the animals related to the supplier, setting 10 items per page
        $animals = $supplier->animals()->paginate(10);

        return view('suppliers.show', compact('supplier', 'animals'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);

        $supplier->update($request->all());

        return redirect()->route('suppliers.index')->with('success', 'تم تحديث المورد بنجاح!');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'تم حذف المورد بنجاح!');
    }
}