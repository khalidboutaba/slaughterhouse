@extends('layouts.app')

@section('title', 'تعديل تفاصيل البيع')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>المبيعات</h3>
                <p class="text-subtitle text-muted">تعديل تفاصيل البيع</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">المبيعات</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> تعديل المبيعة</h4>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger" style="margin: 30px">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action="{{ route('sales.update', $sale->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <h6>الماشية <span class="text-danger">*</span></h6>
                                        <div class="form-group">
                                            <select class="choices form-select" name="animal_id" id="animal-select" required>
                                                <option value="" disabled>اختر الماشية</option>
                                                @foreach($animals as $animal)
                                                    <option value="{{ $animal->id }}" {{ old('animal_id', $sale->animal_id) == $animal->id ? 'selected' : '' }}>
                                                        {{ $animal->type }}{{ $animal->id }} - {{ $animal->weight }}كجم (متوفر{{ $animal->available_weight }}كجم) - {{ $animal->total_price }}د.م ({{ $animal->price_per_kg }} د.م/كجم) - (الأحشاء: {{ $animal->entrails_price }} د.م)
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('animal_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <h6>العميل <span class="text-danger">*</span></h6>
                                        <div class="form-group">
                                            <select class="choices form-select" name="customer_id" required>
                                                <option value="" disabled>اختر العميل</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ old('customer_id', $sale->customer_id) == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('customer_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="quantity">الكمية <span class="text-danger">*</span></label><br>
                                            
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="quantity" id="quantity1_4" value="1/4" 
                                                       {{ $sale->quantity == '0.25' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="quantity1_4">1/4</label>
                                            </div>
                                            
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="quantity" id="quantity1_2" value="1/2" 
                                                       {{ $sale->quantity == '0.50' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="quantity1_2">النصف</label>
                                            </div>
                                            
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="quantity" id="quantity3_4" value="3/4" 
                                                       {{ $sale->quantity == '0.75' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="quantity3_4">3/4</label>
                                            </div>
                                            
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="quantity" id="quantity1" value="1" 
                                                       {{ $sale->quantity == '1.00' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="quantity1">كامل</label>
                                            </div>
                                        </div>
                                        @error('quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="components">الأجزاء <span class="text-danger">*</span></label><br>
                                            
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="components[]" id="shoulder" value="كتف" 
                                                       {{ in_array('كتف', $sale->components ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="كتف">كتف</label>
                                            </div>
                                            
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="components[]" id="thigh" value="فخذ" 
                                                       {{ in_array('فخذ', $sale->components ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="فخذ">فخذ</label>
                                            </div>
                                        </div>
                                        @error('components')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <input type="hidden" id="hidden-available-weight" name="hidden_available_weight" value="0">
                                    <input type="hidden" id="initial-weight" name="initial_weight" value="{{ old('weight', $sale->weight) }}">
                                    
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="weight">الوزن (كجم) <span class="text-danger">*</span></label>
                                            <input type="number" id="weight" min="0" step="0.01" class="form-control"
                                                placeholder="الوزن" name="weight" value="{{ old('weight', $sale->weight) }}" required>
                                            <small id="available-weight" class="form-text text-muted">الوزن المتاح: 0 كجم</small>
                                            @error('weight')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="price_per_kg">السعر(د.م / كجم) <span class="text-danger">*</span></label>
                                            <input type="number" id="price_per_kg" class="form-control"
                                                placeholder="السعر" name="price_per_kg" value="{{ old('price_per_kg', $sale->price_per_kg) }}" required>
                                            @error('price_per_kg')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="total_price">السعر الإجمالي (د.م)</label>
                                            <input type="text" id="total_price" class="form-control"
                                                placeholder="السعر الإجمالي" name="total_price" value="{{ old('total_price', $sale->total_price) }}" readonly>
                                            @error('total_price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="final_price">السعر النهائي (د.م) <small>(بعد خفض سعر الأحشاء)</small></label>
                                            <input type="text" id="final_price" class="form-control"
                                                placeholder="السعر النهائي" name="final_price" value="{{ old('final_price', $sale->final_price) }}" readonly>
                                            @error('final_price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="note" class="form-label">ملاحظات</label>
                                            <textarea class="form-control" id="note" name="note" rows="3">{{ old('note', $sale->note) }}</textarea>
                                            @error('note')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">حفظ التعديلات</button>
                                        @can('sale-list')
                                        <a href="{{ route('sales.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
                                        @endcan
                                    </div>

                                    <div class="col-12 mt-3">
                                        <p><span class="text-danger">*</span> الحقول التي تحتوي على النجمة الحمراء إلزامية.</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- // Basic multiple Column Form section end -->
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
<script src="{{ asset('assets/static/js/pages/form-element-select.js') }}"></script>
<script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var weightInput = document.getElementById('weight');
        var pricePerKgInput = document.getElementById('price_per_kg');
        var totalPriceInput = document.getElementById('total_price');
        var finalPriceInput = document.getElementById('final_price'); // Input for final price
        const animalSelect = document.getElementById('animal-select'); // Animal select dropdown
        let entrailsPrice = 0; // Initialize entrails price
        const form = document.querySelector('form'); // Adjust this if your form has a specific ID or class
        const quantityRadios = document.querySelectorAll('input[name="quantity"]'); // Quantity radio buttons

        // Function to calculate total price
        function calculateTotalPrice() {
            var weight = parseFloat(weightInput.value) || 0;
            var pricePerKg = parseFloat(pricePerKgInput.value) || 0;
            var totalPrice = weight * pricePerKg;
            totalPriceInput.value = totalPrice.toFixed(2); // Display total price with 2 decimal places
            calculateFinalPrice(); // Calculate final price whenever total price is calculated
        }

        // Function to calculate final price
        function calculateFinalPrice() {
            const totalPrice = parseFloat(totalPriceInput.value) || 0;
            const selectedQuantity = document.querySelector('input[name="quantity"]:checked');

            let quantity = 1; // Default is 1 for "كامل"
            if (selectedQuantity) {
                // Convert the fractional values into decimal form
                switch (selectedQuantity.value) {
                    case "1/4":
                        quantity = 0.25;
                        break;
                    case "1/2":
                        quantity = 0.5;
                        break;
                    case "3/4":
                        quantity = 0.75;
                        break;
                    case "1":
                        quantity = 1;
                        break;
                    default:
                        quantity = 1; // Default to full if not recognized
                }
            }

            const discount = entrailsPrice * quantity; // Multiply entrails price by the fractional quantity
            const finalPrice = totalPrice - discount; // Subtract the discount from total price
            finalPriceInput.value = finalPrice.toFixed(2); // 2 decimal places
        }

        // Function to update the entrails price when an animal is selected
        function updateEntrailsPrice() {
            const selectedOption = animalSelect.options[animalSelect.selectedIndex];
            if (selectedOption) {
                // Extract entrails price from option text
                const entrailsPriceMatch = selectedOption.textContent.match(/الأحشاء:\s*(\d+(\.\d+)?)\s*د\.م/);
                entrailsPrice = entrailsPriceMatch ? parseFloat(entrailsPriceMatch[1]) : 0;
                calculateFinalPrice(); // Recalculate final price whenever entrails price is updated
            }
        }

        // Function to initialize available weight
        function initializeValues() {
            const selectedOption = animalSelect.options[animalSelect.selectedIndex];
            const availableWeightText = selectedOption.textContent;
            const availableWeightMatch = availableWeightText.match(/\(متوفر\s*(\d+(\.\d+)?)\s*كجم\)/);
            const availableWeight = availableWeightMatch ? parseFloat(availableWeightMatch[1]) : 0;

            const initialWeight = parseFloat($('#initial-weight').val()) || 0;
            const soldWeight = parseFloat(weightInput.value) || 0;
            const remainingAvailableWeight = availableWeight + initialWeight - soldWeight;

            $('#hidden-available-weight').val(availableWeight);
            $('#available-weight').text(remainingAvailableWeight.toFixed(2));
            weightInput.setAttribute('max', (availableWeight + initialWeight).toFixed(2));
        }

        // Function to handle the selection of the correct quantity on page load (for edit)
        function initializeQuantity() {
            const selectedQuantity = document.querySelector('input[name="quantity"]:checked');
            if (selectedQuantity) {
                calculateFinalPrice(); // Ensure final price is calculated with the initial quantity
            }
        }

        // Add new function to control the weight input based on quantity
        function updateWeightBasedOnQuantity() {
            const selectedQuantity = document.querySelector('input[name="quantity"]:checked');
            const selectedOption = animalSelect.options[animalSelect.selectedIndex];
            //const availableWeight = parseFloat($('#hidden-available-weight').val()) || 0;
            const weightMatch = selectedOption.textContent.match(/- (\d+(\.\d+)?)كجم/);
            const availableWeight = weightMatch ? parseFloat(weightMatch[1]) : 0; // Extract weight
            console.log('Extracted Weight:', availableWeight);

            let quantityFraction = 1; // Default to full
            if (selectedQuantity) {
                switch (selectedQuantity.value) {
                    case "1/4":
                        quantityFraction = 0.25;
                        break;
                    case "1/2":
                        quantityFraction = 0.5;
                        break;
                    case "3/4":
                        quantityFraction = 0.75;
                        break;
                    case "1":
                        quantityFraction = 1;
                        break;
                }
            }

            const maxWeight = (availableWeight * quantityFraction) + 5; // Add 5 kg margin
            const minWeight = (availableWeight * quantityFraction) - 5; // Subtract 5 kg margin

            weightInput.setAttribute('max', maxWeight.toFixed(2));
            weightInput.setAttribute('min', Math.max(0, minWeight).toFixed(2)); // Ensure min doesn't go below 0
        }

        // Add event listeners for weight and price inputs
        weightInput.addEventListener('input', function() {
            calculateTotalPrice();
            const enteredWeight = parseFloat(weightInput.value) || 0;
            const initialWeight = parseFloat($('#initial-weight').val()) || 0;
            const availableWeight = parseFloat($('#hidden-available-weight').val()) || 0;

            const weightDifference = enteredWeight - initialWeight;
            const adjustedAvailableWeight = availableWeight - weightDifference;

            $('#available-weight').text(adjustedAvailableWeight.toFixed(2));

            if (enteredWeight > availableWeight + initialWeight) {
                weightInput.setCustomValidity('الوزن يجب أن يكون أقل من أو يساوي الوزن المتاح.');
            } else {
                weightInput.setCustomValidity('');
            }
        });

        pricePerKgInput.addEventListener('input', function() {
            calculateTotalPrice(); // Calculate total price when price per kg changes
        });

        // Event listener for quantity change
        quantityRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                calculateFinalPrice();
                updateWeightBasedOnQuantity(); // Update weight based on selected quantity
            });
        });

        // Form submission event listener
        form.addEventListener('submit', function(event) {
            const checkboxes = document.querySelectorAll('input[name="components[]"]');
            const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

            if (!isChecked) {
                event.preventDefault(); // Prevent form submission
                alert('يرجى تحديد على الأقل عنصر واحد.');
            }
        });

        // Initialize values on page load
        initializeValues();
        updateEntrailsPrice(); // Ensure entrails price is set on page load
        initializeQuantity(); // Set the initial quantity properly
        updateWeightBasedOnQuantity(); // Set the initial weight limits based on selected quantity

        // Update available weight and entrails price when animal is selected
        animalSelect.addEventListener('change', function () {
            updateEntrailsPrice(); // Update entrails price
            initializeValues(); // Re-initialize available weight
            updateWeightBasedOnQuantity(); // Update weight based on selected quantity
        });
    });
</script>

@endsection
