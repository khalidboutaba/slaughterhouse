@extends('layouts.app')

@section('title', 'إضافة دور جديد')

@section('styles')
<link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>الأدوار</h3>
                <p class="text-subtitle text-muted">إضافة دور جديد</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">الأدوار</li>
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
                        <h4 class="card-title">إضافة دور جديد</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action="{{ route('roles.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name">إسم الدور<span class="text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control"
                                                placeholder="إسم الدور" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-7 col-6">
                                        <div class="form-group">
                                            <label for="name">الصلاحيات :<span class="text-danger">*</span></label>
                                            <ul class="list-group">
                                                @foreach($permission as $value)
                                                    <li class="list-group-item">
                                                        <input id="checkbox-{{ $value->id }}" class="form-check-input me-1" type="checkbox" name="permission[{{ $value->id }}]" value="{{ $value->id }}">
                                                        <label for="checkbox-{{ $value->id }}">{{ $value->name }}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @error('permission')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">حفظ</button>
                                        @can('role-list')
                                        <a href="{{ route('roles.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
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
