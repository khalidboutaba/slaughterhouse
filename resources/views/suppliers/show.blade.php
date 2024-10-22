@extends('layouts.app')

@section('title', 'الموردون')

@section('styles')
<link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">

@endsection


@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>الموردون</h3>
                <p class="text-subtitle text-muted">اكتشف التفاصيل الكاملة حول الموردين. توفر هذه الصفحة عرضاً شاملاً لكل المعلومات المتعلقة بالموردين.</p>
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
                                <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">معلومات التوريد</a>
                              </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="col-md-12 col-sm-12">
                                  <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <h4 class="card-title"><i class="bi bi-person"></i> &nbsp; {{ $supplier->name }}</h4>
                                            <p class="card-text">
                                                <i class="bi bi-phone"></i> &nbsp;{{ $supplier->phone }}
                                            </p>
                
                                            <p class="card-text">
                                                <small class="text-muted">تاريخ الإنشاء: {{ $supplier->created_at }}.</small>
                                            </p>
                                            <p class="card-text">
                                                <small class="text-muted">تاريخ التحديث: {{ $supplier->updated_at }}.</small>
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
                                            <h4 class="card-title">سجل الواردات</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <p class="card-text">يعرض هذا الجدول قائمة الواردات مع التفاصيل.</p>
                            
                                                <!-- Table with outer spacing -->
                                                <div class="table-responsive">
                                                    @if($supplier->animals->isEmpty())
                                                    <p class="card-text">
                                                        <div class="alert alert-light-warning color-warning">
                                                            <i class="bi bi-exclamation-triangle" style="margin: 10px"></i>ملاحظات
                                                            <p>لا توجد مواشي لهذا المورد.</p>
                                                        </div>
                                                    </p>
                                                    @else
                                                    <table class="table" id="table1" style="text-align: center;">
                                                        <thead>
                                                            <tr>
                                                                <th>الرقم التعريفي</th>
                                                                <th>تاريخ الشراء</th>
                                                                <th>النوع</th>
                                                                <th>الوزن (كجم)</th>
                                                                <th>السعر الإجمالي (د.م)</th>
                                                                <th>حالة الدفع</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($supplier->animals as $animal)
                                                            <tr>
                                                                <td class="text-bold-500">{{ $animal->id }}</td>
                                                                <td>{{ $animal->created_at }}</td>
                                                                <td class="text-bold-500">{{ $animal->type }}</td>
                                                                <td class="text-bold-500">{{ $animal->weight }} </td>
                                                                <td class="text-bold-500">{{ $animal->total_price }} </td>
                                                                <td>
                                                                  @if($animal->purchase_status == 'paid')
                                                                      <span class="badge bg-success">مدفوع</span>
                                                                  @elseif($animal->purchase_status == 'partially_paid')
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
                        @can('supplier-edit')
                        <a href="{{route('suppliers.edit', $supplier->id)}}" class="btn btn-primary me-1 mb-1">تعديل</a>
                        @endcan
                        @can('supplier-list')
                        <a href="{{ route('suppliers.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
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

