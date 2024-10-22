@extends('layouts.app')

@section('title', 'العملاء')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>العملاء</h3>
                <p class="text-subtitle text-muted">تفاعل سهل وفعال مع بيانات العملاء، مع أدوات لإدارة وتحديث المعلومات بدقة واحترافية.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">العملاء</li>
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
                    قائمة العملاء
                </h5>
                @can('customer-create')
                <a href="{{ route('customers.create') }}" class="btn icon btn-success"><span>إضافة</span></a>
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
                                    <th style="text-align: center;">الإسم</th>
                                    <th style="text-align: center;">الهاتف</th>
                                    <th style="text-align: center;">تاريخ التسجيل</th>
                                    <th style="text-align: center;">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($customers->isEmpty())
                                    <tr>
                                        <td>لا يوجد عملاء حاليا.</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @else
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td>{{ $customer->id }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->created_at }}</td>
                                            <td>
                                                <div class="button-group">
                                                    @can('customer-show')
                                                    <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-outline-primary">عرض</a>
                                                    @endcan
                                                    @can('customer-edit')
                                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-outline-primary">تعديل</a>
                                                    @endcan
                                                    @can('customer-delete')
                                                        <!-- Trigger button for modal -->
                                                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $customer->id }}">
                                                            حذف
                                                        </button>

                                                        <!-- Delete form (will be submitted via the modal) -->
                                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" id="delete-form-{{ $customer->id }}" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <!-- Include the delete modal -->
                                                        @include('partials.delete-modal', ['id' => $customer->id])
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
