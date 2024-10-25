@extends('layouts.app')

@section('title', 'إضافة بيع جديد')

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
                <p class="text-subtitle text-muted">إضافة بيع جديد</p>
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
                        <h4 class="card-title">يرجى ملء النموذج لإضافة مبيعة جديدة إلى النظام.</h4>
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
                            <form class="form" method="POST" action="{{ route('sales.store') }}">
                                @csrf
                                <div class="row">

                                    <div class="col-md-6 mb-4">
                                        <h6>العميل <span class="text-danger">*</span></h6>
                                        <div class="form-group">
                                            <select class="choices form-select" name="customer_id" required>
                                                <option value="" disabled selected>اختر العميل</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('customer_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <h6>الماشية <span class="text-danger">*</span></h6>
                                        <div class="form-group">
                                            <select class="choices form-select" name="animal_id" id="animal-select" required>
                                                <option value="" disabled selected>اختر الماشية</option>
                                                @foreach($animals as $animal)
                                                    <option value="{{ $animal->id }}">
                                                        {{ $animal->type }}{{ $animal->id }} - {{ $animal->weight }}كجم (متوفر{{ $animal->available_weight }}كجم) - {{ $animal->total_price }}د.م ({{ $animal->price_per_kg }} د.م/كجم) - (الأحشاء: {{ $animal->entrails_price }} د.م)
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('animal_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="quantity">الكمية <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="quantity" id="quantity1_4" value="1/4" checked>
                                                <label class="form-check-label" for="quantity1_4">1/4</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="quantity" id="quantity1_2" value="1/2">
                                                <label class="form-check-label" for="quantity1_2">النصف</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="quantity" id="quantity3_4" value="3/4">
                                                <label class="form-check-label" for="quantity3_4">3/4</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="quantity" id="quantity1" value="1">
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
                                                <input class="form-check-input" type="checkbox" name="components[]" id="shoulder" value="كتف">
                                                <label class="form-check-label" for="كتف">كتف</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="components[]" id="thigh" value="فخذ">
                                                <label class="form-check-label" for="فخذ">فخذ</label>
                                            </div>
                                        </div>
                                        @error('components')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <input type="hidden" id="hidden-available-weight" value="0">
                                    
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="weight">الوزن (كجم) <span class="text-danger">*</span></label>
                                            <input type="number" id="weight" min="0" step="0.01" class="form-control"
                                                placeholder="الوزن" name="weight" value="{{ old('weight') }}" required>
                                            <div><small> الوزن المتوفر: <span id="available-weight">0</span> كجم</small></div>
                                            @error('weight')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="price_per_kg">السعر(د.م / كجم) <span class="text-danger">*</span></label>
                                            <input type="number" id="price_per_kg" class="form-control"
                                                placeholder="السعر" name="price_per_kg" value="{{ old('price_per_kg') }}" required>
                                            @error('price_per_kg')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="total_price">السعر الإجمالي (د.م)</label>
                                            <input type="number" id="total_price" class="form-control" name="total_price" value="{{ old('total_price') }}" readonly>
                                        </div>
                                        @error('total_price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="final_price">السعر النهائي (د.م) <small>(بعد خفض سعر الأحشاء)</small></label>
                                            <input type="number" id="final_price" class="form-control" name="final_price" value="{{ old('final_price') }}" readonly>
                                        </div>
                                        @error('final_price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="note" class="form-label">ملاحظات</label>
                                            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                                            @error('note')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">حفظ</button>
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
    var priceInput = document.getElementById('price_per_kg');
    var totalPriceInput = document.getElementById('total_price');

    function calculateTotalPrice() {
        var weight = parseFloat(weightInput.value) || 0;
        var price = parseFloat(priceInput.value) || 0;
        var totalPrice = weight * price;
        totalPriceInput.value = totalPrice.toFixed(2); // Display total price with 2 decimal places
    }

    // Add event listeners to recalculate the total price when weight or price changes
    weightInput.addEventListener('input', calculateTotalPrice);
    priceInput.addEventListener('input', calculateTotalPrice);
});

// Form submission validation script
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form'); // Adjust this if your form has a specific ID or class

    form.addEventListener('submit', function(event) {
        const checkboxes = document.querySelectorAll('input[name="components[]"]');
        const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

        if (!isChecked) {
            event.preventDefault(); // Prevent form submission
            alert('يرجى تحديد على الأقل عنصر واحد.');
        }
    });
});

// Available weight update and remaining weight calculation script
document.addEventListener('DOMContentLoaded', function () {
    const animalSelect = document.getElementById('animal-select');
    const availableWeightDisplay = document.getElementById('available-weight');
    const weightInput = document.getElementById('weight');
    const hiddenAvailableWeight = document.getElementById('hidden-available-weight');

    // Function to update available weight
    function updateAvailableWeight() {
        const selectedOption = animalSelect.options[animalSelect.selectedIndex];
        if (selectedOption) {
            // Extract available weight from option text
            const optionText = selectedOption.textContent;
            const availableWeightMatch = optionText.match(/\(متوفر\s*(\d+(\.\d+)?)\s*كجم\)/);
            const availableWeight = availableWeightMatch ? parseFloat(availableWeightMatch[1]) : 0;

            // Set the hidden input field with the available weight
            hiddenAvailableWeight.value = availableWeight;

            // Update the available weight display
            availableWeightDisplay.textContent = availableWeight.toFixed(2);
        }
    }

    // Event listener for select change
    animalSelect.addEventListener('change', updateAvailableWeight);

    // Event listener for weight input change
    weightInput.addEventListener('input', function () {
        const enteredWeight = parseFloat(weightInput.value) || 0;
        const availableWeight = parseFloat(hiddenAvailableWeight.value) || 0;
        const remainingWeight = availableWeight - enteredWeight;
        availableWeightDisplay.textContent = remainingWeight.toFixed(2);
    });

    // Initialize available weight
    updateAvailableWeight();
});

// Entrails price and final price calculation script
document.addEventListener('DOMContentLoaded', function () {
    const animalSelect = document.getElementById('animal-select');
    const weightInput = document.getElementById('weight');
    const pricePerKgInput = document.getElementById('price_per_kg');
    const totalPriceInput = document.getElementById('total_price');
    const finalPriceInput = document.getElementById('final_price');
    const quantityRadios = document.querySelectorAll('input[name="quantity"]');

    let entrailsPrice = 0; // This will store the entrails price from the selected animal

    // Function to update the entrails price when an animal is selected
    function updateEntrailsPrice() {
        const selectedOption = animalSelect.options[animalSelect.selectedIndex];
        if (selectedOption) {
            // Extract entrails price from option text
            const entrailsPriceMatch = selectedOption.textContent.match(/الأحشاء:\s*(\d+(\.\d+)?)\s*د\.م/);
            entrailsPrice = entrailsPriceMatch ? parseFloat(entrailsPriceMatch[1]) : 0;
            console.log('Entrails Price:', entrailsPrice); // Log the extracted entrails price
        }
    }

    // Function to calculate total price
    function calculateTotalPrice() {
        const weight = parseFloat(weightInput.value) || 0;
        const pricePerKg = parseFloat(pricePerKgInput.value) || 0;
        const totalPrice = weight * pricePerKg;
        totalPriceInput.value = totalPrice.toFixed(2); // 2 decimal places

        calculateFinalPrice(); // Call final price calculation
    }

    // Function to calculate the final price
    function calculateFinalPrice() {
        const totalPrice = parseFloat(totalPriceInput.value) || 0;
        const selectedQuantity = document.querySelector('input[name="quantity"]:checked').value;

        let quantityFraction = 1; // default is 1 for "كامل"
        if (selectedQuantity === "1/4") quantityFraction = 0.25;
        else if (selectedQuantity === "1/2") quantityFraction = 0.5;
        else if (selectedQuantity === "3/4") quantityFraction = 0.75;

        const discount = entrailsPrice * quantityFraction; // Calculate the entrails discount
        const finalPrice = totalPrice - discount; // Subtract the discount from total price

        finalPriceInput.value = finalPrice.toFixed(2); // 2 decimal places
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

            const maxWeight = (availableWeight * quantityFraction) + 20; // Add 5 kg margin
            const minWeight = (availableWeight * quantityFraction) - 20; // Subtract 5 kg margin

            weightInput.setAttribute('max', maxWeight.toFixed(2));
            weightInput.setAttribute('min', Math.max(0, minWeight).toFixed(2)); // Ensure min doesn't go below 0
        }

    // Event listener for animal selection change
    animalSelect.addEventListener('change', function () {
        updateEntrailsPrice();
        calculateTotalPrice();
        updateWeightBasedOnQuantity();
    });

    // Event listeners for weight and price per kg inputs
    weightInput.addEventListener('input', function() {
        calculateTotalPrice(); // Calculate total price when weight changes
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
});

</script>




@endsection
