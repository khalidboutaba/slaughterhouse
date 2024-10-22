@extends('layouts.app')

@section('title', 'المبيعات')

@section('styles')
<link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
@endsection


@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>المبيعات</h3>
                <p class="text-subtitle text-muted">استعرض التفاصيل الكاملة حول المبيعة. توفر هذه الصفحة عرضاً شاملاً لكل المعلومات المتعلقة بالمبيعة.</p>
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
    <!-- Basic card section start -->
    <section id="content-types">
        <div class="row">

            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-content">

                        <div class="card-body">
                            <h4 class="card-title" style="padding: 20px">المبيعة {{ $sale->id }}</h4>
                            <div class="list-group">

                                @if(isset($sale->animal))
                                <a class="list-group-item list-group-item-action">
                                  <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">الماشية :</h5>
                                  </div>
                                  <p class="mb-1">
                                    {{ $sale->animal->type }} {{ $sale->animal->id }}
                                  </p>
                                </a>
                              @endif

                              @if(isset($sale->customer))
                                <a class="list-group-item list-group-item-action">
                                  <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">العميل :</h5>
                                  </div>
                                  <p class="mb-1">
                                    {{ $sale->customer->name }}
                                  </p>
                                </a>
                              @endif

                                @if(isset($sale->quantity))
                                @php
                                    // Find the fraction representation of the sale's quantity
                                    $formattedQuantity = array_search($sale->quantity, $quantityMap);
                                @endphp
                                <a class="list-group-item list-group-item-action">
                                  <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">الكمية</h5>
                                  </div>
                                  <p class="mb-1">
                                    {{ $formattedQuantity ?? $sale->quantity }}
                                  </p>
                                </a>
                              @endif

                              @if(isset($sale->components))
                                <a class="list-group-item list-group-item-action">
                                  <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">الأجزاء :</h5>
                                  </div>
                                  <p class="mb-1">
                                    {{ implode(', ', $sale->components) }}
                                  </p>
                                </a>
                              @endif

                              <!-- Display weight if it exists -->
                              @if(isset($sale->weight))
                                <a class="list-group-item list-group-item-action">
                                  <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">الوزن :</h5>
                                  </div>
                                  <p class="mb-1">
                                    {{ $sale->weight }} كيلوجرام
                                  </p>
                                </a>
                              @endif
  
                              <!-- Display total price if it exists -->
                              @if(isset($sale->total_price))
                                <a class="list-group-item list-group-item-action">
                                  <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">ثمن البيع بالكيلوجرام :</h5>
                                  </div>
                                  <p class="mb-1">
                                    {{ $sale->price_per_kg }} د.م
                                  </p>
                                </a>
                              @endif
                          
                              <!-- Display total price if it exists -->
                              @if(isset($sale->total_price))
                                <a class="list-group-item list-group-item-action">
                                  <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">ثمن البيع الإجمالي :</h5>
                                  </div>
                                  <p class="mb-1">
                                    {{ $sale->total_price }} د.م
                                  </p>
                                </a>
                              @endif

                              <!-- Display total price if it exists -->
                            @if(isset($sale->final_price))
                              <a class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">ثمن البيع النهائي :</h5>
                                </div>
                                <p class="mb-1">
                                  {{ $sale->final_price }} د.م
                                </p>
                              </a>
                            @endif
                            </div>
                          
                            <!-- Display note or fallback if no note exists -->
                            <p class="card-text">
                              <div class="alert alert-light-warning color-warning">
                                <i class="bi bi-exclamation-triangle" style="margin: 10px"></i>ملاحظات
                                <p>{{ $sale->note ?? 'لا توجد ملاحظات' }}</p>
                              </div>
                            </p>
                          
                            <!-- Display timestamps -->
                            <p class="card-text">
                              <small class="text-muted">تاريخ الإضافة: {{ $sale->created_at }}.</small>
                            </p>
                            <p class="card-text">
                              <small class="text-muted">تاريخ آخر تحديث: {{ $sale->updated_at }}.</small>
                            </p>
                          </div>
                        
                    </div>
                    <div class="card-footer text-end">
                        @can('sale-edit')
                        <a href="{{route('sales.edit', $sale->id)}}" class="btn btn-primary me-1 mb-1">تعديل</a>
                        @endcan
                        @can('sale-list')
                        <a href="{{ route('sales.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">الفاتورة</h4>
                            <p class="card-text">
                                <p class="card-text">
                                    <div class="alert alert-light">
                                        <h4 class="alert-heading">السعر الإجمالي :</h4>
                                        <p>{{ $sale->total_price }} د.م</p>
                                    </div>
                                </p>
                                 
                           </p>
                            <p class="card-text">
                                <div class="alert alert-secondary">
                                    <h4 class="alert-heading">خصم ثمن الأحشاء ({{ $formattedQuantity ?? $sale->quantity }}) :</h4>
                                    <p>{{ $sale->animal->entrails_price * $sale->quantity }} د.م</p>
                                </div>
                            </p>
                            <p class="card-text">
                                <div class="alert alert-light">
                                    <h4 class="alert-heading">السعر النهائي :</h4>
                                    <p>{{ $sale->final_price }} د.م.</p>
                                </div> 
                           </p>
                            <p class="card-text">
                                <div class="alert alert-secondary">
                                    <h4 class="alert-heading">دفع :</h4>
                                    <p>{{ $sale->total_paid }} د.م</p>
                                </div>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                 سجل الدفعات &nbsp;<span class="badge bg-secondary"> {{ $sale->payments->count() }}</span>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                                            @if($sale->payments->isEmpty())
                                                <div class="accordion-body">لا توجد دفعات لهذا البيع.</div>
                                            @else
                                                <ul>
                                                    @foreach($sale->payments as $payment)
                                                        <li>
                                                            <div class="accordion-body">{{ $payment->payment_date }} : <code>{{ $payment->amount }} د.م</code></div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </p>
                            <p class="card-text">
                              @if($sale->final_price - $sale->total_paid == 0)
                                  <div class="alert alert-light-success color-success">
                                      <h4 class="alert-heading">تمت الدفعة بالكامل!</h4>
                                      <p>السعر النهائي قد تم دفعه بالكامل.</p>
                                  </div>
                              @else
                                  <div class="alert alert-light">
                                      <h4 class="alert-heading">الباقي : </h4>
                                      <p>{{ $sale->final_price - $sale->total_paid }} د.م.</p>
                                  </div>
                              @endif
                          </p>
                            
                        </div>
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
