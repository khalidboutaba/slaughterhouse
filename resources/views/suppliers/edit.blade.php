@extends('layouts.app')

@section('title', 'تعديل مورد')

@section('styles')
<link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>الموردون</h3>
                <p class="text-subtitle text-muted">تعديل مورد</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">الموردون</li>
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
                        <h4 class="card-title">تعديل المورد</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action="{{ route('suppliers.update', $supplier->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name">الإسم الكامل <span class="text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control"
                                                placeholder="الإسم" name="name" value="{{ old('name', $supplier->name) }}" required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="phone">الهاتف</label>
                                            <input type="number" id="phone" class="form-control"
                                                placeholder="الهاتف" name="phone" value="{{ old('phone', $supplier->phone) }}" required>
                                            @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="note" class="form-label">ملاحظات</label>
                                            <textarea class="form-control" id="note" name="note" rows="3">{{ old('note', $supplier->note) }}</textarea>
                                            @error('note')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">حفظ التعديلات</button>
                                        @can('supplier-list')
                                        <a href="{{ route('suppliers.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
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
