<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Animal;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:sale-list|sale-show|sale-create|sale-edit|sale-delete', ['only' => ['index']]);
         $this->middleware('permission:sale-show', ['only' => ['show']]);
         $this->middleware('permission:sale-create', ['only' => ['create','store']]);
         $this->middleware('permission:sale-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:sale-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // Get sales with related customer and animal, ordered by created_at in descending order
        $sales = Sale::with('customer', 'animal')
            ->orderBy('created_at', 'desc')
            ->get();

        // Define the quantity map
        $quantityMap = [
            '1/4' => 0.25,
            '1/2' => 0.5,
            '3/4' => 0.75,
            '1' => 1,
        ];

        return view('sales.index', compact('sales', 'quantityMap'));
    }

    public function create()
{
    $customers = Customer::all();
    $animals = Animal::where('sold_status', '!=', 'fully_sold')
                 ->where('available_weight', '>', 0)
                 ->orderBy('created_at', 'desc')
                 ->get();

    // Prepare to hold the status of animal components
    $animalComponentsStatus = [];

    foreach ($animals as $animal) {
        // Fetch previous sales for the animal
        $sales = Sale::where('animal_id', $animal->id)->get();

        // Determine sold components
        $soldComponents = [
            'shoulder' => false,
            'thigh' => false,
        ];

        foreach ($sales as $sale) {
            // Example: Assuming 'quantity' can be a decimal representing fraction of the animal sold
            if ($sale->component == 'shoulder') {
                $soldComponents['shoulder'] = true;
            } elseif ($sale->component == 'thigh') {
                $soldComponents['thigh'] = true;
            }
        }

        $animalComponentsStatus[$animal->id] = $soldComponents;
    }

    return view('sales.create', compact('customers', 'animals', 'animalComponentsStatus'));
}


    public function store(Request $request)
    {
        // Define the mapping for fractional quantity values
        $quantityMap = [
            '1/4' => 0.25,
            '1/2' => 0.5,
            '3/4' => 0.75,
            '1' => 1,
        ];
    
        // Validate the input fields
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'animal_id' => 'required|exists:animals,id',
            'price_per_kg' => 'required|numeric|min:1', // Ensure price per kg is provided
            'weight' => 'required|numeric|min:0',
            'quantity' => 'required|string|in:1/4,1/2,3/4,1', // Validate as string based on options
            'components' => 'required|array|min:1', // Validate components field as an array
            'components.*' => 'string', // Validate each component as a string
            'note' => 'nullable|string',
        ], [
            'components.required' => 'الرجاء تحديد الأجزاء.',
            'components.min' => 'يجب تحديد جزء واحد على الأقل.',
        ]);
    
        // Fetch the animal and its current available weight
        $animal = Animal::findOrFail($request->animal_id);
        $animalWeight = $animal->weight;
        $animalPricePerKg = $animal->price_per_kg;
        $entrails_price = $animal->entrails_price;

        // Check if the provided price_per_kg is greater than the animal's price_per_kg
        if ($request->input('price_per_kg') <= $animalPricePerKg) {
            return redirect()->back()->withErrors('يجب أن يكون سعر البيع للكيلوغرام أكبر من سعر الشراء للماشية المختارة.');
        }
    
        // Convert the fractional quantity to numeric
        $requestedQuantity = $quantityMap[$request->input('quantity')];
        $pricePerKg = $request->input('price_per_kg');
        $weight = $request->input('weight');
    
        // Calculate total price
        $totalPrice = $pricePerKg * $weight;
        $finalPrice = $totalPrice - ($entrails_price * $requestedQuantity);
    
        // Check if the weight exceeds the available weight
        if ($weight > $animal->available_weight) {
            return redirect()->back()->withErrors('الوزن المطلوب يتجاوز الكمية المتاحة للماشية.');
        }
    
        // Prepare the data for saving
        $data = $request->all();
        $data['components'] = $request->input('components', []); // Get components array or empty array
        $data['sale_date'] = now(); // Automatically set the sale date to now
        $data['quantity'] = $requestedQuantity; // Convert fractional quantity to numeric
        $data['total_price'] = $totalPrice; // Set the calculated total price
        $data['final_price'] = $finalPrice;

        // Create the sale record
        Sale::create($data);
    
        // Calculate the total weight sold for the animal (including the newly added sale)
        $totalSold = $animal->sales()->sum('weight'); // Sum weight, not quantity
    
        // Update the animal's available weight after the sale
        $animal->available_weight -= $weight;
    
        // Update the sold status based on the remaining available weight
        if ($animal->available_weight <= 0) {
            $animal->update(['sold_status' => 'fully_sold', 'available_weight' => 0]);
        } elseif ($animal->available_weight > 0) {
            $animal->update(['sold_status' => 'partially_sold']);
        }
    
        // Redirect to the sales index page with success message
        return redirect()->route('sales.index')->with('success', 'تم إنشاء البيع بنجاح!');
    }
    


    public function show(Sale $sale)
    {
        // Define the quantity map
        $quantityMap = [
            '1/4' => 0.25,
            '1/2' => 0.5,
            '3/4' => 0.75,
            '1' => 1,
        ];
    
        // Calculate the total paid amount for the sale
        $totalPaid = $sale->payments()->sum('amount');
    
        return view('sales.show', compact('sale', 'quantityMap', 'totalPaid'));
    }

    public function edit(Sale $sale)
    {
        $customers = Customer::all();
        $animals = Animal::where('sold_status', '!=', 'fully_sold')
                ->orderBy('created_at', 'desc')
                ->get();
    
        // Add available weight to each animal
        foreach ($animals as $animal) {
            $totalSoldWeight = Sale::where('animal_id', $animal->id)->sum('weight');
            $animal->available_weight = $animal->weight - $totalSoldWeight;
        }
    
        return view('sales.edit', compact('sale', 'customers', 'animals'));
    }

    public function update(Request $request, Sale $sale)
    {
        // Define the mapping for fractional quantity values
        $quantityMap = [
            '1/4' => 0.25,
            '1/2' => 0.5,
            '3/4' => 0.75,
            '1' => 1,
        ];

        // Validate the input fields
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'animal_id' => 'required|exists:animals,id',
            'price_per_kg' => 'required|numeric|min:1', // Ensure price per kg is provided
            'weight' => 'required|numeric|min:0',
            'quantity' => 'required|string|in:1/4,1/2,3/4,1', // Validate as string based on options
            'components' => 'required|array|min:1', // Validate components field as an array
            'components.*' => 'string', // Validate each component as a string
            'note' => 'nullable|string',
        ], [
            'components.required' => 'الرجاء تحديد الأجزاء.',
            'components.min' => 'يجب تحديد جزء واحد على الأقل.',
        ]);

        // Fetch the animal and its current available weight
        $animal = Animal::find($request->input('animal_id'));
        $animalWeight = $animal->weight;
        $animalPricePerKg = $animal->price_per_kg;
        $entrails_price = $animal->entrails_price;

        // Check if the provided price_per_kg is greater than the animal's price_per_kg
        if ($request->input('price_per_kg') <= $animalPricePerKg) {
            return redirect()->back()->withErrors('يجب أن يكون سعر البيع للكيلوغرام أكبر من سعر الشراء للماشية المختارة.');
        }

        // Convert the fractional quantity to numeric
        $newQuantity = $quantityMap[$request->input('quantity')];
        $pricePerKg = $request->input('price_per_kg');
        $newWeight = $request->input('weight');

        // Calculate total price
        $totalPrice = $pricePerKg * $newWeight;

        $finalPrice = $totalPrice - ($entrails_price * $newQuantity);

        // Recalculate the available weight considering the previous sale weight
        $previousWeight = $sale->weight;
        $adjustedAvailableWeight = $animal->available_weight + $previousWeight;

        // Check if the updated weight exceeds the available weight
        if ($newWeight > $adjustedAvailableWeight) {
            return redirect()->back()->withErrors('الوزن المطلوب يتجاوز الكمية المتاحة للماشية.');
        }

        // Prepare the data for updating
        $data = $request->all();
        $data['components'] = $request->input('components', []); // Get components array or empty array
        $data['quantity'] = $newQuantity; // Convert fractional quantity to numeric
        $data['total_price'] = $totalPrice; // Set the calculated total price
        $data['final_price'] = $finalPrice;

        // Update the sale record
        $sale->update($data);

        // Adjust the available weight by subtracting the new weight and adding back the previous weight
        $animal->available_weight = $adjustedAvailableWeight - $newWeight;

        // Update the animal's sold status based on the new available weight
        if ($animal->available_weight <= 0) {
            $animal->update(['sold_status' => 'fully_sold', 'available_weight' => 0]);
        } elseif ($animal->available_weight > 0) {
            $animal->update(['sold_status' => 'partially_sold']);
        }

        // Redirect to the sales index page with success message
        return redirect()->route('sales.index')->with('success', 'تم تحديث البيع بنجاح!');
    }



    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'تم حذف البيع بنجاح!');
    }
    
}
