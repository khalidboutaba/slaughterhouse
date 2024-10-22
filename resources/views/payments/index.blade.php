@extends('layouts.app')

@section('title', 'Payments')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>الدفعات</h3>
            <p class="text-subtitle text-muted">عرض شامل للدفعات المتعلقة بالمبيعات والمشتريات، مع أدوات لتحليل وإدارة البيانات المالية بكفاءة.</p>
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
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">دفعات المبيعات</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">دفعات المشتريات</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                      <div class="col-md-12 col-sm-12">
                        @include('payments.partials.index_sales_payments')
                      </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                      <div class="col-12 col-md-12">
                        @include('payments.partials.index_purchase_payments')
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Basic Card types section end -->

    

@endsection

@section('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatableinit.js') }}"></script>
@endsection
