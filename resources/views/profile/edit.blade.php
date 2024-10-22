@extends('layouts.app')

@section('title', 'الخدمات')

@section('styles')
<style>
    body {
        direction: rtl;
        text-align: right;
    }
    .breadcrumb-header {
        float: right;
    }
    .breadcrumb {
        justify-content: flex-end;
    }
    .btn {
        float: left;
        margin-left: 10px;
    }
</style>
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>الحساب</h3>
                <p class="text-subtitle text-muted">إدارة وتعديل بيانات الحساب الشخصي بشكل سهل وفعال.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">الحساب</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

<section class="section">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">إعدادات الحساب</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill"
                                href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                aria-selected="true">معلومات الحساب</a>
                            <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                                href="#v-pills-messages" role="tab" aria-controls="v-pills-messages"
                                aria-selected="false">تغيير كلمة المرور</a>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                                aria-labelledby="v-pills-profile-tab">
                                <div class="col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">معلومات الحساب</h4>
                                        </div>
                                        <div class="card-content">
                                            @include('profile.partials.update-profile-information-form')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                aria-labelledby="v-pills-messages-tab">
                                <div class="col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">تغيير كلمة المرور</h4>
                                        </div>
                                        <div class="card-content">
                                            @include('profile.partials.update-password-form')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

@endsection

@section('scripts')
    <!-- Need: Apexcharts -->
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
@endsection
