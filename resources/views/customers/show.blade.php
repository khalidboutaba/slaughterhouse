@extends('layouts.app')

@section('title', 'العملاء')

@section('styles')
<link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">

@endsection 

@section('content') 

<div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>العملاء</h3>
          <p class="text-subtitle text-muted">عرض جميع المعلومات المتعلقة بالعميل بشكل مفصل، بما في ذلك بيانات الاتصال و سجل الشراء.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">لوحة التحكم</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">العملاء</li>
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
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">معلومات عامة</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">معلومات الشراء</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="payment-tab" data-bs-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">معلومات الدفع</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="col-md-12 col-sm-12">
                      <div class="card">
                        <div class="card-content">
                          <div class="card-body">
                            <h4 class="card-title"> <i class="bi bi-person"></i> &nbsp;{{ $customer->name }}</h4>
                            <p class="card-text">
                                <i class="bi bi-phone"></i> &nbsp; {{ $customer->phone }}
                            </p>
                            <p class="card-text">
                              <small class="text-muted">تاريخ الإنشاء: {{ $customer->created_at }}.</small>
                            </p>
                            <p class="card-text">
                              <small class="text-muted">تاريخ التحديث: {{ $customer->updated_at }}.</small>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="col-12 col-md-12">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">سجل المشتريات</h4>
                        </div>
                        <div class="card-content">
                          <div class="card-body">
                            <p class="card-text"> يعرض هذا الجدول قائمة المشتريات مع تفاصيل مثل اسم العميل و السعر الخاص بالبيع. </p>
                            <!-- Table with outer spacing -->
                            <div class="table-responsive">
                                @if($customer->sales->isEmpty())
                                <div class="alert alert-light-warning color-warning">
                                    <i class="bi bi-exclamation-triangle" style="margin: 10px"></i>لم يتم العثور على أي مبيعات لهذا العميل.</p>
                                  </div>
                                
                                @else
                                <table class="table" id="table1" style="text-align: center;">
                                  <thead>
                                    <tr>
                                      <th style="text-align: center;">الرقم التعريفي</th>
                                      <th style="text-align: center;">تاريخ العملية</th>
                                      <th style="text-align: center;">اسم العميل</th>
                                      <th style="text-align: center;">الماشية</th>
                                      <th style="text-align: center;">الكمية</th>
                                      <th style="text-align: center;">الأجزاء</th>
                                      <th style="text-align: center;">الوزن</th>
                                      <th style="text-align: center;">السعر النهائي</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($customer->sales as $sale)
                                    <tr>
                                      <td class="text-bold-500">{{ $sale->id }}</td>
                                      <td>{{ $sale->sale_date }}</td>
                                      <td>{{ $sale->customer->name }}</td>
                                      <td class="text-bold-500">{{ $sale->animal->type }} {{ $sale->animal->id }}</td>
                                      <td class="text-bold-500">
                                        @php
                                            // Find the fraction representation of the sale's quantity
                                            $formattedQuantity = array_search($sale->quantity, $quantityMap);
                                        @endphp
                                        {{-- Display the fraction if found, otherwise display the original quantity --}}
                                        {{ $formattedQuantity ?? $sale->quantity }}
                                    </td>
                                    <td>
                                        {{-- Display the components, joining them with commas --}}
                                        {{ implode(', ', $sale->components) }}
                                    </td>
                                      <td class="text-bold-500">{{ $sale->weight }}</td>
                                      <td class="text-bold-500">{{ $sale->final_price }}</td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                                @endif
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                    <div class="col-12 col-md-12">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">سجل الدفعات</h4>
                        </div>
                        <div class="card-content">
                          <div class="card-body">
                            <p class="card-text"> يعرض هذا الجدول قائمة الدفعات مع التفاصيل. </p>
                            <!-- Table with outer spacing -->
                            <div class="table-responsive">
                                @if($customer->payments->isEmpty())
                                <div class="alert alert-light-warning color-warning">
                                    <i class="bi bi-exclamation-triangle" style="margin: 10px"></i>لم يتم العثور على أي مدفوعات لهذا العميل.</p>
                                  </div>
                                @else
                                <table class="table" id="table11" style="text-align: center;">
                                  <thead>
                                    <tr>
                                      <th style="text-align: center;">الرقم التعريفي</th>
                                      <th style="text-align: center;">المبيعة</th>
                                      <th style="text-align: center;">المبلغ المدفوع</th>
                                      <th style="text-align: center;">تاريخ الدفع</th>
                                      <th style="text-align: center;">حالة الدفع</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($customer->payments as $payment)
                                    <tr>
                                      <td class="text-bold-500">{{ $payment->id }}</td>
                                      <td class="text-bold-500">المبيعة {{ $payment->sale->id }}</td>
                                      <td class="text-bold-500">{{ $payment->amount }}</td>
                                      <td class="text-bold-500">{{ $payment->payment_date }}</td>
                                      <td>
                                        @if($payment->sale->sale_status == 'paid')
                                            <span class="badge bg-success">مدفوع</span>
                                        @elseif($payment->sale->sale_status == 'partially_paid')
                                            <span class="badge bg-warning">دفع جزئي</span>
                                        @else
                                            <span class="badge bg-danger">غير مدفوع</span>
                                        @endif
                                    </td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                                @endif
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-end">
                @can('customer-edit')
                <a href="{{route('customers.edit', $customer->id)}}" class="btn btn-primary me-1 mb-1">تعديل</a>
                @endcan
                @can('customer-list')
                <a href="{{ route('customers.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
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
<script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>
<script src="{{ asset('assets/static/js/pages/datatableinit.js') }}"></script>
@endsection