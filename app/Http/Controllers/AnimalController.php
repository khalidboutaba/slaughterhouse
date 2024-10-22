<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Ensure this is imported
use App\Models\Animal;
use App\Models\Supplier;

class AnimalController extends Controller
{ 

    function __construct()
    {
         $this->middleware('permission:animal-list|animal-show|animal-create|animal-edit|animal-delete', ['only' => ['index']]);
         $this->middleware('permission:animal-show', ['only' => ['show']]);
         $this->middleware('permission:animal-create', ['only' => ['create','store']]);
         $this->middleware('permission:animal-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:animal-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $animals = Animal::with('supplier')
            ->orderBy('created_at', 'desc') // Order by created_at date in descending order
            ->get();

        return view('animals.index', compact('animals'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('animals.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        // Calculate the total price
        $totalPrice = $request->input('weight') * $request->input('price_per_kg');

        // Validate input
        $request->validate([
            'type' => 'required|string',
            'price_per_kg' => 'required|numeric|min:1', // Validate price_per_kg
            'entrails_price' => 'required|numeric',
            'weight' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'origin' => 'nullable|string',
            'reference' => 'nullable|string|unique:animals,reference', // Ensure reference is unique
            'note' => 'nullable|string',
        ]);

        $errors = [];
        if ($request->input('entrails_price') >= $totalPrice) {
            $errors['entrails_price'] = 'سعر الأمعاء يجب أن يكون أقل من السعر الإجمالي.';
        }
        if ($request->input('price_per_kg') >= $totalPrice) {
            $errors['price_per_kg'] = 'سعر الكيلوغرام يجب أن يكون أقل من السعر الإجمالي.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Prepare data for storing
        $animalData = $request->only(['type', 'price_per_kg', 'entrails_price', 'weight', 'supplier_id', 'origin', 'reference', 'note']);
        $animalData['total_price'] = $totalPrice;

        // Set available_weight to be the same as weight at creation
        $animalData['available_weight'] = $request->input('weight');

        // Create new animal record
        Animal::create($animalData);

        return redirect()->route('animals.index')->with('success', 'تم إضافة الماشية بنجاح!');
    }

    public function show(Animal $animal)
    {
        // Eager load the sales and payments relationships
        $animal->load('sales', 'payments');
        
        // Define a mapping array to map Arabic animal types to image filenames
        $animalImages = [
            'بقر' => 'cow.png',
            'خروف' => 'sheep.png',
        ];

        // Define the quantity map
        $quantityMap = [
            '1/4' => 0.25,
            '1/2' => 0.5,
            '3/4' => 0.75,
            '1' => 1,
        ];

        // Determine the image filename based on the animal's type
        $animalImage = $animalImages[$animal->type] ?? 'default.png';

        return view('animals.show', compact('animal', 'animalImage', 'quantityMap'));
    }

    public function edit(Animal $animal)
    {
        $suppliers = Supplier::all();
        return view('animals.edit', compact('animal', 'suppliers'));
    }

    public function update(Request $request, Animal $animal)
    {
        // Calculate the total price
        $totalPrice = $request->input('weight') * $request->input('price_per_kg');

        // Validate input
        $request->validate([
            'type' => 'required|string',
            'price_per_kg' => 'required|numeric|min:1', // Validate price_per_kg
            'entrails_price' => 'required|numeric',
            'weight' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'origin' => 'nullable|string',
            'reference' => 'nullable|string|unique:animals,reference,' . $animal->id, // Unique reference, ignore current animal
            'note' => 'nullable|string',
        ]);

        // Custom validation checks
        $errors = [];
        if ($request->input('entrails_price') >= $totalPrice) {
            $errors['entrails_price'] = 'سعر الأمعاء يجب أن يكون أقل من السعر الإجمالي.';
        }
        if ($request->input('price_per_kg') >= $totalPrice) {
            $errors['price_per_kg'] = 'سعر الكيلوغرام يجب أن يكون أقل من السعر الإجمالي.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }


        // Prepare data for updating
        $animalData = $request->only(['type', 'price_per_kg', 'entrails_price', 'weight', 'supplier_id', 'origin', 'reference', 'note']);
        $animalData['total_price'] = $totalPrice;

        // Update available weight: new weight - sold weight
        // If weight is updated, also update the available weight
        if ($request->has('weight')) {
            $totalSoldWeight = $animal->sales()->sum('weight');
            $animalData['available_weight'] = $animalData['weight'] - $totalSoldWeight;
        }

        // Update the animal record
        $animal->update($animalData);

        return redirect()->route('animals.index')->with('success', 'تم تحديث الماشية بنجاح!');
    }

    public function destroy(Animal $animal)
    {
        $animal->delete();
        return redirect()->route('animals.index')->with('success', 'تم حذف الماشية بنجاح!');
    }

}
