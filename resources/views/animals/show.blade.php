@extends('layouts.app')
@section('title', 'المواشي')
@section('styles')
<link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">

@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3> المواشي </h3>
          <p class="text-subtitle text-muted">استكشف التفاصيل الكاملة حول الماشية بما في ذلك النوع، المنشأ، والتاريخ. توفر هذه الصفحة عرضاً شاملاً لكل ما تحتاج معرفته.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">لوحة التحكم</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">المواشي</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <!-- Basic card section start -->
    <section id="content-types">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">معلومات مفصلة عن الماشية</h5>
            </div>
            <div class="card-body">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">معلومات عامة</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">معلومات المورد</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">معلومات البيع</a>
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
                        <div class="d-flex justify-content-center">
                          <img class="card-img-top img-fluid" src="{{ asset('img/animals/' . $animalImage) }}" alt="{{ $animal->type }}" style="height: 17rem; width: 35rem;" />
                        </div>
                        <div class="card-body">
                          <h4 class="card-title" style="padding: 20px">{{ $animal->type }} {{ $animal->id }}</h4>
                          <div class="list-group">
                        
                            <!-- Display weight if it exists -->
                            @if(isset($animal->weight))
                              <a class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">الوزن :</h5>
                                </div>
                                <p class="mb-1">
                                  {{ $animal->weight }} كيلوجرام
                                </p>
                              </a>
                            @endif

                            <!-- Display weight if it exists -->
                            @if(isset($animal->available_weight))
                              <a class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">الوزن المتاح :</h5>
                                </div>
                                <p class="mb-1">
                                  {{ $animal->available_weight }} كيلوجرام
                                </p>
                              </a>
                            @endif

                            <!-- Display total price if it exists -->
                            @if(isset($animal->total_price))
                              <a class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">ثمن الشراء بالكيلوجرام :</h5>
                                </div>
                                <p class="mb-1">
                                  {{ $animal->price_per_kg }} د.م
                                </p>
                              </a>
                            @endif
                        
                            <!-- Display total price if it exists -->
                            @if(isset($animal->total_price))
                              <a class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">ثمن الشراء الإجمالي :</h5>
                                </div>
                                <p class="mb-1">
                                  {{ $animal->total_price }} د.م
                                </p>
                              </a>
                            @endif
                        
                            <!-- Display entrails price if it exists -->
                            @if(isset($animal->entrails_price))
                              <a class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">ثمن الأحشاء :</h5>
                                </div>
                                <p class="mb-1">
                                  {{ $animal->entrails_price }} د.م
                                </p>
                              </a>
                            @endif
                        
                            <!-- Display reference if it exists -->
                            @if(isset($animal->reference))
                              <a class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">الرقم المرجعي :</h5>
                                </div>
                                <p class="mb-1">
                                  {{ $animal->reference }}
                                </p>
                              </a>
                            @endif
                        
                            <!-- Display origin if it exists -->
                            @if(isset($animal->origin))
                              <a class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">المنشأ :</h5>
                                </div>
                                <p class="mb-1">
                                  {{ $animal->origin }}
                                </p>
                              </a>
                            @endif
                        
                          </div>
                        
                          <!-- Display note or fallback if no note exists -->
                          <p class="card-text">
                            <div class="alert alert-light-warning color-warning">
                              <i class="bi bi-exclamation-triangle" style="margin: 10px"></i>ملاحظات
                              <p>{{ $animal->note ?? 'لا توجد ملاحظات' }}</p>
                            </div>
                          </p>
                        
                          <!-- Display timestamps -->
                          <p class="card-text">
                            <small class="text-muted">تاريخ الإضافة: {{ $animal->created_at }}.</small>
                          </p>
                          <p class="card-text">
                            <small class="text-muted">تاريخ آخر تحديث: {{ $animal->updated_at }}.</small>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">المورد</h4>
                    </div>
                    <div class="card-content">
                      <div class="card-body">
                        @if(isset($animal->supplier) && isset($animal->supplier->name))
                          <p class="card-text"> <i class="bi bi-person"></i> &nbsp; {{ $animal->supplier->name }}</p>
                        @endif
                    
                        @if(isset($animal->supplier) && isset($animal->supplier->phone))
                          <p class="card-text"> <i class="bi bi-phone"></i> &nbsp; {{ $animal->supplier->phone }}</p>
                        @endif
                      </div>
                    </div>
                    <div class="card-text">
                      @can('supplier-show')
                      <a href="{{ route('suppliers.show', $animal->supplier->id) }}" class="btn btn-sm btn-outline-primary">المزيد حول المورد</a>
                      @endcan
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                  <div class="col-12 col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">سجل المبيعات</h4>
                      </div>
                      <div class="card-content">
                        <div class="card-body">
                          <p class="card-text"> يعرض هذا الجدول قائمة المبيعات مع تفاصيل مثل اسم العميل و السعر الخاص بالبيع. </p>
                          <!-- Table with outer spacing -->
                          <div class="table-responsive">
                            @php
                                // Translate the sold status to Arabic
                                switch ($animal->sold_status) {
                                    case 'not_sold':
                                        $statusMessage = 'الماشية غير مباعة بعد'; // Not sold
                                        break;
                                    case 'partially_sold':
                                        $statusMessage = 'الماشية مباعة جزئياً'; // Partially sold
                                        break;
                                    case 'fully_sold':
                                        $statusMessage = 'الماشية مباعة بالكامل'; // Fully sold
                                        break;
                                    default:
                                        $statusMessage = 'حالة غير معروفة'; // Unknown status
                                        break;
                                }
                            @endphp

                            @if($animal->sales->isEmpty())
                            <p class="card-text">
                              <div class="alert alert-light-warning color-warning">
                                <i class="bi bi-exclamation-triangle" style="margin: 10px"></i>لا توجد مبيعات لهذه الماشية</p>
                              </div>
                              </p>
                            
                            @else
                            <table class="table table-lg">
                              <thead>
                                <tr>
                                  <th>الرقم التعريفي</th>
                                  <th>تاريخ العملية</th>
                                  <th>اسم العميل</th>
                                  <th>الكمية</th>
                                  <th>الوزن</th>
                                  <th>السعر للكيلوجرام</th>
                                  <th>السعر النهائي</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($animal->sales as $sale)
                                <tr>
                                  <td class="text-bold-500">{{ $sale->id }}</td>
                                  <td>{{ $sale->sale_date }}</td>
                                  <td class="text-bold-500">{{ $sale->customer->name }}</td>
                                  <td>
                                    @php
                                        // Find the fraction representation of the sale's quantity
                                        $formattedQuantity = array_search($sale->quantity, $quantityMap);
                                    @endphp
                                    {{-- Display the fraction if found, otherwise display the original quantity --}}
                                    {{ $formattedQuantity ?? $sale->quantity }}
                                </td>
                                  <td class="text-bold-500">{{ $sale->weight }}</td>
                                  <td class="text-bold-500">{{ $sale->price_per_kg }}</td>
                                  <td class="text-bold-500">{{ $sale->final_price }}</td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                            @endif
                            <div class="alert alert-light">{{$statusMessage}}.</div>
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
                          <p class="card-text"> يعرض هذا الجدول سجل الدفعات للمورد مع التفاصيل. </p>
                          <!-- Table with outer spacing -->
                          <div class="table-responsive">

                            @if($animal->payments->isEmpty())
                            <p class="card-text">
                              <div class="alert alert-light-warning color-warning">
                                <i class="bi bi-exclamation-triangle" style="margin: 10px"></i>لم يتم تسجيل أي دفعات حاليا</p>
                              </div>
                              </p>
                            @else

                            @if($animal->purchase_status === 'partially_paid')
                                <div class="alert alert-light-info color-info">
                                    <i class="bi bi-exclamation-circle" style="margin: 10px"></i> تم دفع مبلغ الماشية جزئياً
                                </div>
                            @elseif($animal->purchase_status === 'fully_paid')
                                <div class="alert alert-light-success color-success">
                                    <i class="bi bi-check-circle" style="margin: 10px"></i>تم دفع مبلغ الماشية بالكامل
                                </div>
                            @else
                                <div class="alert alert-light-danger color-danger">
                                    <i class="bi bi-exclamation-triangle" style="margin: 10px"></i>حالة الدفع غير معروفة
                                </div>
                            @endif
                            <table class="table table-lg">
                              <thead>
                                <tr>
                                  <th>الرقم التعريفي</th>
                                  <th>المبلغ المدفوع</th>
                                  <th>تاريخ العملية</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($animal->payments as $payment)
                                <tr>
                                  <td class="text-bold-500">{{ $payment->id }}</td>
                                  <td class="text-bold-500">{{ $payment->amount }}</td>
                                  <td class="text-bold-500">{{ $payment->payment_date }}</td>
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
            <div class="card-footer text-end">
                @can('animal-edit')
                <a href="{{route('animals.edit', $animal->id)}}" class="btn btn-primary me-1 mb-1">تعديل</a>
                @endcan
                @can('animal-list')
                <a href="{{ route('animals.index') }}" class="btn btn-light-secondary me-1 mb-1">الرجوع إلى القائمة</a>
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

@endsection