@extends('layouts.app')

@section('title', 'جميع المواشي')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>المواشي</h3>
                <p class="text-subtitle text-muted">استعرض بيانات المواشي بطريقة تفاعلية وسهلة، مع إمكانية إدارة المعلومات وتحديثها بكفاءة عالية.</p>
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

    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    قائمة المواشي
                </h5>
                @can('animal-create')
                <a href="{{ route('animals.create') }}" class="btn icon btn-success"><span>إضافة</span></a>
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
                                    <th style="text-align: center;">النوع</th>
                                    <th style="text-align: center;">الوزن الإجمالي (كجم)</th>
                                    <th style="text-align: center;">الوزن المتاح (كجم)</th>
                                    <th style="text-align: center;">السعر (د.م/كجم)</th>
                                    <th style="text-align: center;">السعر الإجمالي (د.م)</th>
                                    <th style="text-align: center;">حالة البيع</th>
                                    <th style="text-align: center;">حالة الدفع</th>
                                    <th style="text-align: center;">تاريخ التسجيل</th>
                                    <th style="text-align: center;">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($animals->isEmpty())
                                    <tr>
                                        <td>لا توجد مواشي متاحة.</td>
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
                                    @foreach ($animals as $animal)
                                        <tr>
                                            <td>{{ $animal->id }}</td>
                                            <td>{{ $animal->type }}</td>
                                            <td>{{ $animal->weight }}</td>
                                            <td>{{ $animal->available_weight }}</td>
                                            <td>{{ $animal->price_per_kg }}</td>
                                            <td>{{ $animal->total_price }}</td>
                                            <td>
                                                @if($animal->sold_status == 'fully_sold')
                                                    <span class="badge bg-light-success">مباع بالكامل</span>
                                                @elseif($animal->sold_status == 'partially_sold')
                                                    <span class="badge bg-light-warning">مباع جزئياً</span>
                                                @else
                                                    <span class="badge bg-light-danger">غير مباع</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($animal->purchase_status == 'paid')
                                                    <span class="badge bg-success">مدفوع</span>
                                                @elseif($animal->purchase_status == 'partially_paid')
                                                    <span class="badge bg-warning">دفع جزئي</span>
                                                @else
                                                    <span class="badge bg-danger">غير مدفوع</span>
                                                @endif
                                            </td>
                                            <td>{{ $animal->created_at }}</td>
                                            <td>
                                                <div class="button-group">
                                                    @can('animal-show')
                                                    <a href="{{ route('animals.show', $animal->id) }}" class="btn btn-outline-primary">عرض</a>
                                                    @endcan
                                                    @can('animal-edit')
                                                    <a href="{{ route('animals.edit', $animal->id) }}" class="btn btn-outline-primary">تعديل</a>
                                                    @endcan
                                                    @can('animal-delete')
                                                        <!-- Trigger button for modal -->
                                                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $animal->id }}">
                                                            حذف
                                                        </button>

                                                        <!-- Delete form (will be submitted via the modal) -->
                                                        <form action="{{ route('animals.destroy', $animal->id) }}" method="POST" id="delete-form-{{ $animal->id }}" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <!-- Include the delete modal -->
                                                        @include('partials.delete-modal', ['id' => $animal->id])
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
    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>

@endsection
