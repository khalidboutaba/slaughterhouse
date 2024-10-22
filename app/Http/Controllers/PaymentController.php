<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Animal;
use App\Models\SalesPayment;
use App\Models\PurchasePayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:payment-list|payment-show|payment-create|payment-edit|payment-delete', ['only' => ['index']]);
         $this->middleware('permission:payment-show', ['only' => ['show']]);
         $this->middleware('permission:payment-create', ['only' => ['create','store']]);
         $this->middleware('permission:payment-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:payment-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // Fetch all sales payments with related sale data, ordered by created_at descending
        $salesPayments = SalesPayment::with('sale')  // Eager load related 'sale' data
            ->orderBy('created_at', 'desc') // Order by created_at descending
            ->get()
            ->map(function ($payment) {
                return [
                    'payment_id' => $payment->id,
                    'sale' => $payment->sale,
                    'total_paid' => $payment->amount,
                    'created_at' => $payment->created_at
                ];
            });

        // Fetch all purchase payments with related animal data, ordered by created_at descending
        $purchasePayments = PurchasePayment::with('animal')  // Eager load related 'animal' data
            ->orderBy('created_at', 'desc') // Order by created_at descending
            ->get()
            ->map(function ($payment) {
                return [
                    'payment_id' => $payment->id,
                    'animal' => $payment->animal,
                    'total_paid' => $payment->amount,
                    'created_at' => $payment->created_at
                ];
            });

        return view('payments.index', compact('salesPayments', 'purchasePayments'));
    }


    public function create()
    {
        $animals = Animal::orderBy('created_at', 'desc')->get(); // Order by created_at date in descending order
        $sales = Sale::orderBy('created_at', 'desc')->get(); // Order by created_at date in descending order
        
        return view('payments.create', compact('animals', 'sales'));
    }

    public function store(Request $request)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'amount' => 'required|numeric|min:0',
        'payment_date' => 'required|date',
        'payment_type' => 'required|in:sale,purchase',
        'sale_id' => 'nullable|exists:sales,id',
        'animal_id' => 'nullable|exists:animals,id',
    ]);

    if ($validated['payment_type'] === 'sale') {
        // Retrieve the sale based on sale_id
        $sale = Sale::find($validated['sale_id']);

        // Ensure the sale exists
        if (!$sale) {
            return redirect()->back()->withErrors(['sale_id' => 'البيع المختار غير موجود.']);
        }

        // Calculate the remaining balance for the sale
        $remainingSaleAmount = $sale->final_price - $sale->total_paid;

        // Ensure the payment amount does not exceed the remaining balance
        if ($validated['amount'] > $remainingSaleAmount) {
            return redirect()->back()->withErrors(['amount' => 'مبلغ الدفع يتجاوز الرصيد المتبقي لهذه البيع.']);
        }

        // Create the sales payment
        SalesPayment::create([
            'sale_id' => $validated['sale_id'],
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
        ]);

        // Update the total paid in the Sale model
        $sale->total_paid += $validated['amount'];
        $sale->updateSaleStatus();
        $sale->save();

    } elseif ($validated['payment_type'] === 'purchase') {
        // Retrieve the animal based on animal_id
        $animal = Animal::find($validated['animal_id']);

        // Ensure the animal exists
        if (!$animal) {
            return redirect()->back()->withErrors(['animal_id' => 'الماشية المختارة غير موجودة.']);
        }

        // Calculate the remaining balance for the purchase
        $remainingPurchaseAmount = $animal->total_price - $animal->total_paid;

        // Ensure the payment amount does not exceed the remaining balance
        if ($validated['amount'] > $remainingPurchaseAmount) {
            return redirect()->back()->withErrors(['amount' => 'مبلغ الدفع يتجاوز الرصيد المتبقي لهذه العملية الشرائية.']);
        }

        // Create the purchase payment
        PurchasePayment::create([
            'animal_id' => $validated['animal_id'],
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
        ]);

        // Update the total paid in the Animal model
        $animal->total_paid += $validated['amount'];
        $animal->updatePurchaseStatus();  // Updates the purchase_status based on total_paid and total_price
        $animal->save();
    }

    // Redirect with success message
    return redirect()->route('payments.index')->with('success', 'تم تسجيل الدفع بنجاح.!');
}


    public function show($paymentType, $payment)
    {
        if ($paymentType === 'sale') {
            $paymentDetails = SalesPayment::find($payment);
            $linkedRecord = Sale::find($paymentDetails->sale_id); // Fetch related sale
        } elseif ($paymentType === 'purchase') {
            $paymentDetails = PurchasePayment::find($payment);
            $linkedRecord = Animal::find($paymentDetails->animal_id); // Fetch related animal
        }

        if (!$paymentDetails) {
            abort(404, 'Payment not found.');
        }

        return view('payments.show', [
            'payment' => $paymentDetails,
            'paymentType' => $paymentType,
            'linkedRecord' => $linkedRecord // Pass the related sale or animal
        ]);
    }


    public function edit($id)
    {
        // Determine if the payment is a sale or purchase
        $payment = SalesPayment::find($id) ?? PurchasePayment::find($id);

        if (!$payment) {
            abort(404);
        }

        $animals = Animal::orderBy('created_at', 'desc')->get();
        $sales = Sale::orderBy('created_at', 'desc')->get();
        $paymentType = $payment instanceof SalesPayment ? 'sale' : 'purchase';

        return view('payments.edit', compact('payment', 'animals', 'sales', 'paymentType'));
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_type' => 'required|in:sale,purchase',
            'sale_id' => 'nullable|exists:sales,id',
            'animal_id' => 'nullable|exists:animals,id',
        ]);

        // Find the payment, either in SalesPayment or PurchasePayment
        $payment = SalesPayment::find($id) ?? PurchasePayment::find($id);

        if (!$payment) {
            abort(404);
        }

        // Store the old amount before updating
        $oldAmount = $payment->amount;

        // Check if the payment is a sale payment
        if ($payment instanceof SalesPayment) {
            // Retrieve the sale associated with the payment
            $sale = Sale::find($validated['sale_id']);

            // Calculate the remaining amount after subtracting the old payment
            $remainingSaleAmount = $sale->final_price - ($sale->total_paid - $oldAmount);

            // Ensure the new payment amount does not exceed the remaining balance
            if ($validated['amount'] > $remainingSaleAmount) {
                return redirect()->back()->withErrors(['amount' => 'مبلغ الدفع يتجاوز الرصيد المتبقي لهذا البيع.']);
            }

            // Update the payment details
            $payment->update([
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'sale_id' => $validated['sale_id'],
            ]);

            // Update the total paid in the Sale model
            $sale->total_paid += $validated['amount'] - $oldAmount; // Adjust for the difference
            $sale->updateSaleStatus();
            $sale->save();
        } else {
            // The payment is a purchase payment
            // Retrieve the animal associated with the payment
            $animal = Animal::find($validated['animal_id']);

            // Calculate the remaining amount after subtracting the old payment
            $remainingPurchaseAmount = $animal->total_price - ($animal->total_paid - $oldAmount);

            // Ensure the new payment amount does not exceed the remaining balance
            if ($validated['amount'] > $remainingPurchaseAmount) {
                return redirect()->back()->withErrors(['amount' => 'مبلغ الدفع يتجاوز الرصيد المتبقي لهذه الشراء.']);
            }

            // Update the payment details
            $payment->update([
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'animal_id' => $validated['animal_id'],
            ]);

            // Update the total paid in the Animal model
            $animal->total_paid += $validated['amount'] - $oldAmount; // Adjust for the difference
            $animal->updatePurchaseStatus();  // Updates the purchase_status based on total_paid and total_price
            $animal->save();
        }

        // Redirect back to the payments index with a success message
        return redirect()->route('payments.index')->with('success', 'تم تحديث الدفع بنجاح!');
    }


    public function destroy($id)
    {
        $payment = SalesPayment::find($id) ?? PurchasePayment::find($id);

        if ($payment) {
            // Update the total paid before deleting
            if ($payment instanceof SalesPayment) {
                $sale = Sale::find($payment->sale_id);
                $sale->total_paid -= $payment->amount;
                $sale->save();
            } else {
                $animal = Animal::find($payment->animal_id);
                $animal->total_paid -= $payment->amount;
                $animal->save();
            }

            $payment->delete();
        }

        return redirect()->route('payments.index')->with('success', 'تم حذف الدفع بنجاح!');
    }

}
