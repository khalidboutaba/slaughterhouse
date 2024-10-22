@extends('layouts.app')

@section('title', 'الدفعات')

@section('styles')
<link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">

@endsection


@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>الدفعات</h3>
                <p class="text-subtitle text-muted">اكتشف التفاصيل الكاملة حول الدفعات. توفر هذه الصفحة عرضاً شاملاً لكل المعلومات المتعلقة بالدفعات.</p>
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
    <!-- Basic card section start -->
    <section id="content-types">
        <div class="row">

            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        
                        <div class="card-body">
                                <div class="col-md-12 col-sm-12">
                                  <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <h4 class="card-title">تفاصيل الدفع {{ $payment->id }}</h4>
                                            <div class="card-body">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>الرقم التعريفي</th>
                                                            <th>المبلغ المدفوع</th>
                                                            <th>تاريخ الدفع</th>
                                                            <th>
                                                                @if ($paymentType === 'sale')
                                                                    المبيعة
                                                                @elseif ($paymentType === 'purchase')
                                                                    الماشية
                                                                @endif
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $payment->id }}</td>
                                                            <td>{{ $payment->amount }}</td>
                                                            <td>{{ $payment->payment_date }}</td>
                                                            @if ($paymentType === 'sale')
                                                                <td>المبيعة {{ $linkedRecord->id }}</td>
                                                            @elseif ($paymentType === 'purchase')
                                                                <td>{{ $linkedRecord->type }} {{ $linkedRecord->id }}</td>
                                                            @endif

                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>

                                            <p class="card-text">
                                                <small class="text-muted">تاريخ الإنشاء: {{ $payment->created_at }}.</small>
                                            </p>
                                            <p class="card-text">
                                                <small class="text-muted">تاريخ التحديث: {{ $payment->updated_at }}.</small>
                                            </p>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                          </div>
                    </div>
                    <div class="card-footer text-end">
                        @can('payment-edit')
                        <a href="{{ route('payments.customEdit', ['id' => $payment->id]) }}" class="btn btn-outline-primary">تعديل</a>
                        @endcan
                        @can('payment-list')
                        <a href="{{ route('payments.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
                        @endcan
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Basic Card types section end -->
</div>

@endsection

@section('scripts')

@endsection
