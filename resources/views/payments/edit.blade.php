@extends('layouts.app')

@section('title', 'تعديل دفعة')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>الدفعات</h3>
                <p class="text-subtitle text-muted">تعديل دفعة</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">الدفعات</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">تعديل دفعة</h4>
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
                            <form class="form" method="POST" action="{{ route('payments.customUpdate', ['paymentType' => $paymentType, 'payment' => $payment->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="payment_type">نوع الدفع <span class="text-danger">*</span></label>
                                            <select class="choices form-select" name="payment_type">
                                                <option value="" disabled selected>اختر نوع الدفع</option>
                                                <option value="sale" {{ $paymentType === 'sale' ? 'selected' : '' }}>بيع</option>
                                                <option value="purchase" {{ $paymentType === 'purchase' ? 'selected' : '' }}>شراء</option>
                                            </select>
                                            @error('payment_type')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4" id="animal_field" style="display: none">
                                        <div class="form-group">
                                            <label for="animal_id">الماشية <span class="text-danger">*</span></label>
                                            <select class="choices form-select" name="animal_id" id="animal_id">
                                                <option value="" disabled selected>اختر الماشية</option>
                                                @foreach($animals as $animal)
                                                    <option value="{{ $animal->id }}" {{ old('animal_id', $payment->animal_id) == $animal->id ? 'selected' : '' }}>
                                                        {{ $animal->type }}{{ $animal->id }} - {{ $animal->weight }}كجم (متوفر{{ $animal->available_weight }}كجم) - {{ $animal->total_price }}د.م (دفع: {{ $animal->total_paid }} د.م)
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('animal_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12" id="sale_field" style="display: none">
                                        <div class="form-group">
                                            <label for="sale_id">المبيعة <span class="text-danger">*</span></label>
                                            <select class="choices form-select" name="sale_id" id="sale_id">
                                                <option value="" disabled selected>اختر المبيعة</option>
                                                @foreach($sales as $sale)
                                                    <option value="{{ $sale->id }}" {{ old('sale_id', $payment->sale_id) == $sale->id ? 'selected' : '' }}>
                                                        المبيعة {{ $sale->id }} - {{ $sale->final_price }}د.م (دفع: {{ $sale->total_paid }} د.م)
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('sale_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="payment_date">تاريخ الأداء <span class="text-danger">*</span></label>
                                            <input type="date" id="payment_date" class="form-control"
                                                placeholder="تاريخ الأداء" name="payment_date" value="{{ old('payment_date', $payment->payment_date) }}" required>
                                            @error('payment_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="amount">المبلغ <span class="text-danger">*</span></label>
                                            <input type="text" id="amount" class="form-control"
                                                placeholder="المبلغ" name="amount" value="{{ old('amount', $payment->amount) }}" required>
                                            @error('amount')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>المبلغ المتبقي</label>
                                            <p id="remaining_amount" class="remaining-amount">0 د.م</p>
                                        </div>
                                    </div>

                                    <input type="hidden" id="sale_total" name="sale_total" value="0">
                                    <input type="hidden" id="sale_total_paid" name="sale_total_paid" value="0">
                                    <input type="hidden" id="animal_total" name="animal_total" value="0">
                                    <input type="hidden" id="animal_total_paid" name="animal_total_paid" value="0">

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="note">ملاحظات</label>
                                            <textarea class="form-control" id="note" name="note" rows="3">{{ old('note', $payment->note) }}</textarea>
                                            @error('note')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">حفظ التعديلات</button>
                                        @can('payment-list')
                                        <a href="{{ route('payments.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
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
    <!-- Basic multiple Column Form section end -->
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
<script src="{{ asset('assets/static/js/pages/form-element-select.js') }}"></script>
<script src="{{ asset('assets/extensions/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/static/js/pages/date-picker.js') }}"></script>
<script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set today's date for the payment_date input
        var today = new Date().toISOString().split('T')[0];
        document.getElementById("payment_date").value = today;
    
        // Initialize the payment type and update fields accordingly
        var paymentType = document.querySelector('select[name="payment_type"]').value;
        toggleFields(paymentType);
        
        // Set initial values based on existing payment data
        setInitialValues();
        
        // Event listener for payment type selection
        document.querySelector('select[name="payment_type"]').addEventListener('change', function() {
            toggleFields(this.value);
            updateRemainingAmount(); // Update remaining amount after toggling
        });
    
        // Event listener for sale selection
        document.querySelector('select[name="sale_id"]').addEventListener('change', function() {
            updateSaleInfo(this);
            updateRemainingAmount();
        });
    
        // Event listener for animal selection
        document.querySelector('select[name="animal_id"]').addEventListener('change', function() {
            updateAnimalInfo(this);
            updateRemainingAmount();
        });
    
        // Event listener for amount input
        document.getElementById('amount').addEventListener('input', updateRemainingAmount);
    });
    
    // Function to set initial values based on existing payment data
    function setInitialValues() {
        var amount = parseFloat(document.getElementById('amount').value) || 0;
    
        // Update fields based on existing payment record
        if (document.querySelector('select[name="payment_type"]').value === 'sale') {
            updateSaleInfo(document.querySelector('select[name="sale_id"]'));
        } else {
            updateAnimalInfo(document.querySelector('select[name="animal_id"]'));
        }
    
        // Update remaining amount for the first time
        updateRemainingAmount();
    }
    
    // Function to toggle fields based on payment type
    function toggleFields(paymentType) {
        var saleField = document.getElementById('sale_field');
        var animalField = document.getElementById('animal_field');
    
        if (paymentType === 'sale') {
            saleField.style.display = 'block';
            animalField.style.display = 'none';
        } else if (paymentType === 'purchase') {
            animalField.style.display = 'block';
            saleField.style.display = 'none';
        } else {
            saleField.style.display = 'none';
            animalField.style.display = 'none';
        }
    }
    
    // Function to update sale info
    function updateSaleInfo(select) {
    var selectedOption = select.options[select.selectedIndex].text;
    var matches = selectedOption.match(/المبيعة (\d+) - (.+) د\.م/);
    if (matches) {
        document.getElementById('sale_total').value = parseFloat(matches[2]);
    }
}
    
    // Function to update animal info
    function updateAnimalInfo(select) {
    var selectedOption = select.options[select.selectedIndex].text;
    var matches = selectedOption.match(/-\s([\d,]+\.\d{2})\s?د\.م/);
    if (matches) {
        document.getElementById('animal_total').value = parseFloat(matches[1]);
    }
}
    
    // Function to update the remaining amount
    function updateRemainingAmount() {
    var saleTotal = parseFloat(document.getElementById('sale_total').value) || 0;
    var saleTotalPaid = parseFloat(document.getElementById('sale_total_paid').value) || 0;
    var animalTotal = parseFloat(document.getElementById('animal_total').value) || 0;
    var animalTotalPaid = parseFloat(document.getElementById('animal_total_paid').value) || 0;

    var remainingSale = Math.max(0, saleTotal - saleTotalPaid);
    var remainingAnimal = Math.max(0, animalTotal - animalTotalPaid);

    var totalRemaining = document.querySelector('select[name="payment_type"]').value === 'sale' ? remainingSale : remainingAnimal;

    var amount = parseFloat(document.getElementById('amount').value) || 0;

    // Ensure remaining amount doesn't go negative
    var finalRemaining = Math.max(0, totalRemaining - amount);
    
    document.getElementById('remaining_amount').innerText = finalRemaining + ' د.م';
}

</script>
            
@endsection
