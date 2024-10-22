@extends('layouts.app')

@section('title', 'تعديل مستخدم')

@section('styles')
<link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">

@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>المستخدمون</h3>
                <p class="text-subtitle text-muted">تعديل مستخدم</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">المستخدمون</li>
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
                        <h4 class="card-title">تعديل المستخدم</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action="{{ route('users.update', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name">إسم المستخدم <span class="text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control"
                                                placeholder="إسم المستخدم" name="name" value="{{ old('name', $user->name) }}" required readonly>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email">البريد الإلكتروني <span class="text-danger">*</span></label>
                                            <input type="email" id="email" class="form-control"
                                                placeholder="البريد الإلكتروني" name="email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="password">كلمة السر</label>
                                            <input type="password" id="password" class="form-control"
                                                placeholder="********" name="password">
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="password_confirmation">تأكيد كلمة السر</label>
                                            <input type="password" id="password_confirmation" class="form-control"
                                                placeholder="********" name="password_confirmation">
                                            @error('password_confirmation')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="roles">أدوار المستخدم <span class="text-danger">*</span></label>
                                            <select name="roles[]" class="choices form-select multiple-remove" multiple="multiple">
                                                <optgroup label="الأدوار المتاحة">
                                                    @foreach ($roles as $value => $label)
                                                        <option value="{{ $value }}" {{ isset($userRole[$value]) ? 'selected' : (in_array($value, old('roles', [])) ? 'selected' : '') }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">حفظ التعديلات</button>
                                        @can('user-list')
                                        <a href="{{ route('users.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
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
@endsection
