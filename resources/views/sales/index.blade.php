@extends('layouts.app')

@section('title', 'جميع المبيعات')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>المبيعات</h3>
                <p class="text-subtitle text-muted">عرض شامل للمعاملات التجارية مع أدوات لتحليل ومراقبة أداء المبيعات بدقة.</p>
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

    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    قائمة المبيعات
                </h5>
                @can('sale-create')
                <a href="{{ route('sales.create') }}" class="btn icon btn-success"><span>إضافة</span></a>
                @endcan
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
            @session('success')
                <div class="alert alert-success" style="margin: 30px">
                    <ul>
                        <li>{{ $value }}</li>
                    </ul>
                </div>
            @endsession
            <div class="card-body">
                <div id="loading-spinner" style="display: none; text-align: center; padding: 20px;">
                    <div id="loading-spinner" style="display: none; text-align: center; padding: 20px;">
                        <img src="{{ asset('assets/compiled/svg/puff.svg') }}" class="me-4" style="width: 3rem" alt="audio">
                    </div>
                </div>
                <div id="default-table" style="display: none;">
                    <div class="table-responsive">
                        <table class="table" id="table1" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">رقم التعريف</th>
                                    <th style="text-align: center;">العميل</th>
                                    <th style="text-align: center;">الماشية</th>
                                    <th style="text-align: center;">الكمية</th>
                                    <th style="text-align: center;">الأجزاء</th>
                                    <th style="text-align: center;">الوزن</th>
                                    <th style="text-align: center;">السعر ب كغ</th>
                                    <th style="text-align: center;">السعر النهائي</th>
                                    <th style="text-align: center;">حالة الدفع</th>
                                    <th style="text-align: center;">تاريخ التسجيل</th>
                                    <th style="text-align: center;">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($sales->isEmpty())
                                    <tr>
                                        <td>لا توجد مبيعات حاليا.</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @else
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td>{{ $sale->id }}</td>
                                            <td>{{ $sale->customer->name }}</td>
                                            <td>{{ $sale->animal->type }} {{ $sale->animal->id }}</td>
                                            <td>
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
                                            <td>{{ $sale->weight }}</td>
                                            <td>{{ $sale->price_per_kg }}</td>
                                            <td>{{ $sale->final_price }} د.م</td>
                                            <td>
                                                @if($sale->sale_status == 'paid')
                                                    <span class="badge bg-success">مدفوع</span>
                                                @elseif($sale->sale_status == 'partially_paid')
                                                    <span class="badge bg-warning">دفع جزئي</span>
                                                @else
                                                    <span class="badge bg-danger">غير مدفوع</span>
                                                @endif
                                            </td>
                                            <td>{{ $sale->created_at }}</td>
                                            <td>
                                                <div class="button-group">
                                                    @can('sale-show')
                                                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-outline-primary">عرض</a>
                                                    @endcan
                                                    @can('sale-edit')
                                                    <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-outline-primary">تعديل</a>
                                                    @endcan
                                                    @can('sale-delete')
                                                        <!-- Trigger button for modal -->
                                                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $sale->id }}">
                                                            حذف
                                                        </button>

                                                        <!-- Delete form (will be submitted via the modal) -->
                                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" id="delete-form-{{ $sale->id }}" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <!-- Include the delete modal -->
                                                        @include('partials.delete-modal', ['id' => $sale->id])
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Tables end -->

@endsection

@section('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatableinit.js') }}"></script>
@endsection
