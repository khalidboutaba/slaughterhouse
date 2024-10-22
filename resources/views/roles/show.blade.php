@extends('layouts.app')

@section('title', 'الأدوار')

@section('styles')
<link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">

@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>الأدوار</h3>
          <p class="text-subtitle text-muted">تعرف على التفاصيل الكاملة حول الدور. توفر هذه الصفحة عرضاً شاملاً لكل المعلومات المتعلقة بالدور.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">لوحة التحكم</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">الأدوار</li>
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
                        <div class="card-body py-4 px-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl">
                                    <img src="{{ asset('img/core/role.png') }}" alt="profile">
                                </div>
                                <div class="ms-3 name">
                                    <h5 class="font-bold">{{ $role->name }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                        <p class="card-text"> <strong> الصلاحيات:</strong> </p>
                        <div class="list-group mb-3">
                          @if(!empty($rolePermissions))
                                  @foreach($rolePermissions as $v)
                                  <button type="button" class="list-group-item list-group-item-action">{{ $v->name }}</button>
                                  @endforeach
                              @endif
                        </div>
                        </div>

                        <p class="card-text">
                          <small class="text-muted">تاريخ الإنشاء: {{ $role->created_at }}.</small>
                        </p>
                        <p class="card-text">
                          <small class="text-muted">تاريخ التحديث: {{ $role->updated_at }}.</small>
                        </p>
                    </div>
                    </div>
              </div>
            </div>
            <div class="card-footer text-end">
              @can('role-edit')
              <a href="{{route('roles.edit', $role->id)}}" class="btn btn-primary me-1 mb-1">تعديل</a>
              @endcan
              @can('role-list')
              <a href="{{ route('roles.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
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