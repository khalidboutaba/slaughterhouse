@extends('layouts.app')

@section('title', 'المستخدمون')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>المستخدمون</h3>
                <p class="text-subtitle text-muted">إدارة المستخدمين وتنظيم الأدوار والصلاحيات بكفاءة، مع أدوات متقدمة لمراقبة النشاطات والتفاعلات.</p>
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

    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    قائمة المستخدمين
                </h5>
                @can('user-create')
                <a href="{{ route('users.create') }}" class="btn icon btn-success"><span>إضافة</span></a>
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
                                    <th style="text-align: center;">إسم المستخدم</th>
                                    <th style="text-align: center;">البريد الإلكتروني</th>
                                    <th style="text-align: center;">الأدوار</th>
                                    <th style="text-align: center;">تاريخ التسجيل</th>
                                    <th style="text-align: center;">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->isEmpty())
                                    <tr>
                                        <td>لا يوجد مستخدمين حاليا.</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @else
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if(!empty($user->getRoleNames()))
                                                  @foreach($user->getRoleNames() as $v)
                                                     <label class="badge bg-secondary">{{ $v }}</label>
                                                  @endforeach
                                                @endif
                                              </td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>
                                                <div class="button-group">
                                                    @can('user-show')
                                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-primary">عرض</a>
                                                    @endcan
                                                    @can('user-edit')
                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary">تعديل</a>
                                                    @endcan
                                                    @can('user-delete')
                                                        <!-- Trigger button for modal -->
                                                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $user->id }}">
                                                            حذف
                                                        </button>

                                                        <!-- Delete form (will be submitted via the modal) -->
                                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="delete-form-{{ $user->id }}" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <!-- Include the delete modal -->
                                                        @include('partials.delete-modal', ['id' => $user->id])
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
