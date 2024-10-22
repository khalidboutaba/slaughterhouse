@extends('layouts.app')

@section('title', 'المستخدمون')

@section('styles')
<link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">

@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>المستخدمون</h3>
          <p class="text-subtitle text-muted">تعرف على التفاصيل الكاملة حول المستخدم. توفر هذه الصفحة عرضاً شاملاً لكل المعلومات المتعلقة بالمستخدم.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">لوحة التحكم</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">المستخدمون</li>
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
                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">سجل الأحداث</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="col-md-12 col-sm-12">
                      <div class="card">
                        <div class="card-body py-4 px-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl">
                                    <img src="{{ asset('img/core/profile.png') }}" alt="profile">
                                </div>
                                <div class="ms-3 name">
                                    <h5 class="font-bold">{{ $user->name }}</h5>
                                    <h6 class="text-muted mb-0">{{ $user->email }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              @if($user->getRoleNames()->isNotEmpty())
                                  <strong>الأدوار:</strong>
                                  <div>
                                      @foreach($user->getRoleNames() as $role)
                                      <span class="badge bg-light-secondary mt-3">{{ $role }}</span>
                                      @endforeach
                                  </div>
                              @else
                                  <p>لا توجد أدوار مخصصة لهذا المستخدم.</p>
                              @endif
                          </div>
                      </div>

                        <p class="card-text">
                          <small class="text-muted">تاريخ الإنشاء: {{ $user->created_at }}.</small>
                        </p>
                        <p class="card-text">
                          <small class="text-muted">تاريخ التحديث: {{ $user->updated_at }}.</small>
                        </p>
                    </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="col-12 col-md-12">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">سجل الأحداث</h4>
                        </div>
                        <div class="card-content">
                          <div class="card-body">
                            <div id="loading-spinner" style="display: none; text-align: center; padding: 20px;">
                              <div id="loading-spinner" style="display: none; text-align: center; padding: 20px;">
                                  <img src="{{ asset('assets/compiled/svg/puff.svg') }}" class="me-4" style="width: 3rem" alt="audio">
                              </div>
                            </div>
                            <p class="card-text"> يعرض هذا الجدول قائمة الإجراءات التي قام بها المستخدمون مع تفاصيل مثل الحدث وتاريخ تنفيذه. </p>
                            <!-- Table with outer spacing -->

                            <div class="table-responsive">
                              @if($logs->isEmpty())
                                <p class="card-text">
                                  <div class="alert alert-light-warning color-warning">
                                      <i class="bi bi-exclamation-triangle" style="margin: 10px"></i>ملاحظات
                                      <p>لم يتم العثور على سجلات لهذا المستخدم.</p>
                                  </div>
                                </p>
                                
                                @else
                                <div id="default-table" style="display: none;">
                                  <table class="table" id="table1" style="text-align: center;">                                  <thead>
                                    <tr>
                                      <th>الحدث</th>
                                      <th>تاريخ العملية</th>
                                      <th>عنوان IP</th>
                                      <th>الرابط</th>
                                      <th>الطريقة</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($logs as $log)
                                    <tr>
                                      <td class="text-bold-500">{{ $log->description }}</td>
                                      <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                      <td class="text-bold-500">{{ $log->ip }}</td>
                                      <td class="text-bold-500">{{ $log->url }}</td>
                                      <td class="text-bold-500">{{ $log->method }}</td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                                </div>
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
              @can('user-edit')
              <a href="{{route('users.edit', $user->id)}}" class="btn btn-primary me-1 mb-1">تعديل</a>
              @endcan
              @can('user-list')
              <a href="{{ route('users.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
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