@extends('layouts.app')

@section('title', 'تعديل ماشية')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>المواشي</h3>
                <p class="text-subtitle text-muted">تعديل الماشية</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">المواشي</li>
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
                        <h4 class="card-title">تعديل الماشية</h4>
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
                            <form class="form" method="POST" action="{{ route('animals.update', $animal->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>نوع الماشية <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type" id="cow" value="بقر" {{ $animal->type == 'بقر' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="cow">بقر</label>
                                            </div>
                                                                        
                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="radio" name="type" id="sheep" value="خروف" {{ $animal->type == 'خروف' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sheep">خروف</label>
                                            </div>
                                    
                                            @error('type')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="weight">الوزن (كجم) <span class="text-danger">*</span></label>
                                            <input type="number" id="weight" class="form-control"
                                                placeholder="الوزن" name="weight" value="{{ old('weight', $animal->weight) }}" required>
                                            @error('weight')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="price_per_kg">السعر(د.م / كجم) <span class="text-danger">*</span></label>
                                            <input type="number" id="price_per_kg" class="form-control"
                                                placeholder="السعر" name="price_per_kg" value="{{ old('price_per_kg', $animal->price_per_kg) }}" required>
                                            @error('price_per_kg')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="total_price">السعر الإجمالي (د.م) <span class="text-danger">*</span></label>
                                            <input type="text" id="total_price" class="form-control"
                                                placeholder="السعر الإجمالي" name="total_price" value="{{ old('total_price', $animal->total_price) }}" readonly>
                                            @error('total_price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="entrails_price">سعر الأحشاء (د.م) <span class="text-danger">*</span></label>
                                            <input type="number" id="entrails_price" class="form-control"
                                                placeholder="سعر الأحشاء" name="entrails_price" value="{{ old('entrails_price', $animal->entrails_price) }}" required>
                                            @error('entrails_price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="reference">المنشأ</label>
                                            <select class="choices form-select" name="origin">
                                                <option value="" disabled>اختر المنشأ</option>
                                                <option value="محلي" {{ old('origin', $animal->origin) == 'محلي' ? 'selected' : '' }}>محلي</option>
                                                <option value="أجنبي" {{ old('origin', $animal->origin) == 'أجنبي' ? 'selected' : '' }}>أجنبي</option>
                                                <option value="غير معروف" {{ old('origin', $animal->origin) == 'غير معروف' ? 'selected' : '' }}>غير معروف</option>
                                            </select>
                                            @error('origin')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="reference">المورد<span class="text-danger">*</span></label>
                                            <select class="choices form-select" name="supplier_id" required>
                                                <option value="" disabled>اختر المورد</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $animal->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="reference">الرقم المرجعي</label>
                                            <input type="text" id="reference" class="form-control"
                                                placeholder="الرقم المرجعي" name="reference" value="{{ old('reference', $animal->reference) }}">
                                            @error('reference')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="note" class="form-label">ملاحظات</label>
                                            <textarea class="form-control" id="note" name="note" rows="3">{{ old('note', $animal->note) }}</textarea>
                                            @error('note')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">حفظ التعديلات</button>
                                        @can('animal-list')
                                        <a href="{{ route('animals.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var weightInput = document.getElementById('weight');
        var pricePerKgInput = document.getElementById('price_per_kg');
        var totalPriceInput = document.getElementById('total_price');

        function calculateTotalPrice() {
            var weight = parseFloat(weightInput.value) || 0;
            var pricePerKg = parseFloat(pricePerKgInput.value) || 0;
            var totalPrice = weight * pricePerKg;
            totalPriceInput.value = totalPrice.toFixed(2); // Display total price with 2 decimal places
        }

        // Add event listeners to recalculate the total price when weight or price changes
        weightInput.addEventListener('input', calculateTotalPrice);
        pricePerKgInput.addEventListener('input', calculateTotalPrice);
    });
</script>
@endsection
