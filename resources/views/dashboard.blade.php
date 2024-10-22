@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    <link href="{{ asset('assets/static/css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="page-heading">
    <h3>لوحة التحكم</h3>
</div> 
@if(Auth::user() && Auth::user()->hasRole('Admin'))
<div class="page-content"> 
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldBag-2"></i>
                                    </div>
                                </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">عدد المبيعات اليوم</h6>
                                        <h6 class="font-extrabold mb-0">{{ $numberOfSoldAnimals }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">عدد المواشي المضافة اليوم</h6>
                                    <h6 class="font-extrabold mb-0">{{ $animalsAddedToday }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldBag"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">عدد المواشي المباعة كليا اليوم</h6>
                                    <h6 class="font-extrabold mb-0">{{ $fullySoldAnimalsToday }}</h6>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card"> 
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldBuy"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">الخزينة اليوم</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalRevenueToday }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>المبيعات خلال الشهور 12 الأخيرة</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>لائحة المبيعات اليوم</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>الإسم</th>
                                            <th>الكمية</th>
                                            <th>السعر</th>
                                            <th>الساعة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($salesToday as $sale)
                                        <tr>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md">
                                                        <img src="{{ asset('img/core/profile.png') }}">
                                                    </div>
                                                    <p class="font-bold ms-3 mb-0">{{ $sale->customer->name }}</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                @php
                                                        // Find the fraction representation of the sale's quantity
                                                        $formattedQuantity = array_search($sale->quantity, $quantityMap);
                                                    @endphp
                                                <p class=" mb-0">{{ $formattedQuantity ?? $sale->quantity }}</p>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0">{{ number_format($sale->total_price, 2) }} د.م</p>
                                            </td>
                                            <td class="col-auto">
                                                <p class="mb-0">{{ \Carbon\Carbon::parse($sale->created_at)->format('H:i') }}</p>
                                            </td>
                                            {{-- <td class="col-auto">
                                                <p class=" mb-0">Congratulations on your graduation!</p>
                                            </td> --}}
                                        </tr>
                                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    <div class="alert alert-light-warning color-warning">
                                        <i class="bi bi-exclamation-triangle" style="margin: 10px"></i>لم يتم إجراء أي مبيعات اليوم.</p>
                                    </div>
                                    
                                </td>
                            </tr>
                        @endforelse
                                    </tbody>
                                </table>
                                <div class="px-4">
                                    <a href="{{ route('sales.create') }}" class='btn btn-block btn-xl btn-outline-primary font-bold mt-3'>تسجيل عملية بيع جديدة</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('img/core/profile.png') }}" alt="profile">
                        </div>
                        <div class="ms-3 name">
                            <a href="{{route('profile.edit')}}"><h5 class="font-bold">{{ Auth::user()->name }}</h5></a>
                            <h6 class="text-muted mb-0">{{ Auth::user()->email }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>لائحة العملاء مع عدد المبيعات</h4>
                </div>

                <div class="card-content pb-4">
                    @if($topCustomers->isEmpty())
                        <div class="alert alert-light-warning color-warning" style="margin: 20px">
                            <i class="bi bi-exclamation-triangle" style="margin: 10px"></i>لا توجد مبيعات حاليا.</p>
                        </div>
                    @else
                        @foreach($topCustomers as $topCustomer)
                            <div class="recent-message d-flex px-4 py-3">
                                <div class="avatar avatar-lg">
                                    <img src="{{ asset('img/core/rating.png') }}" alt="top_customer">
                                </div>
                                <div class="name ms-4">
                                    <h5 class="mb-1"><a href="{{ route('customers.show', $topCustomer->customer->id) }}">{{ $topCustomer->customer->name }}</a></h5>
                                    <h6 class="text-muted mb-0"> مجموع المعاملات: {{ $topCustomer->total_sales }}</h6>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="px-4">
                        <a href="{{ route('customers.create') }}" class='btn btn-block btn-xl btn-outline-primary font-bold mt-3'>إضافة عميل جديد</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>المبيعات حسب نوع الماشية</h4>
                </div>
                <div class="card-body">
                    <div id="chart-visitors-profile"></div>
                </div>
            </div>
        </div>
    </section>
</div>
@endif
@endsection

@section('scripts')
    <!-- Need: Apexcharts -->
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/static/js/pages/dashboard.js') }}"></script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Data from Laravel passed to JavaScript
            var salesData = @json($salesByAnimalType);
        
            // Check if salesData has any entries
            var hasData = Object.keys(salesData).length > 0;
    
            // If no data, show an empty chart or placeholder
            if (!hasData) {
                salesData = {"لا توجد بيانات حاليا": 1}; // Placeholder data for an empty chart
            }
    
            // Prepare the data for the chart
            var labels = Object.keys(salesData);
            var data = Object.values(salesData);
    
            // Initialize the chart
            var options = {
                series: data,
                labels: labels,
                colors: ["#435ebe", "#55c6e8"],
                plotOptions: {
                    pie: {
                        donut: {
                            size: "30%",
                        },
                    },
                },
                chart: {
                    type: "donut",
                    width: "100%",
                    height: "350px",
                },
                responsive: [{
                    breakpoint: 450,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
    
            var chart = new ApexCharts(document.querySelector("#chart-visitors-profile"), options);
            chart.render();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Laravel data passed to JavaScript
            var salesData = @json($monthlySalesData);

            // Helper function to get the last 12 months dynamically
            function getLast12Months() {
                const months = [];
                const currentDate = new Date();
                const monthNames = ["يناير", "فبراير", "مارس", "أبريل", "ماي", "يونيو", "يوليوز", "غشت", "شتنبر", "أكتوبر", "نونبر", "دجنبر"];
                
                for (let i = 0; i < 12; i++) {
                    const month = currentDate.getMonth() - i; // Subtract i to go backward
                    const year = currentDate.getFullYear();
                    
                    // Adjust for negative month values (previous years)
                    const adjustedDate = new Date(year, month);
                    const monthLabel = `${monthNames[adjustedDate.getMonth()]} ${adjustedDate.getFullYear()}`;
                    const formattedMonthYear = `${adjustedDate.getFullYear()}-${(adjustedDate.getMonth() + 1).toString().padStart(2, '0')}`;

                    months.push({ label: monthLabel, value: formattedMonthYear });
                }

                return months.reverse(); // Reverse to display from oldest to newest
            }

            // Get the last 12 months with Arabic labels
            const last12Months = getLast12Months();

            // Create sales series with 0 for months with no sales
            const salesSeries = last12Months.map(month => {
                return salesData[month.value] || 0; // Get sales from data or 0 if no sales
            });

            // Extract month labels for the x-axis
            const monthLabels = last12Months.map(month => month.label);

            // Chart options
            var optionsProfileVisit = {
                annotations: {
                    position: "back",
                },
                dataLabels: {
                    enabled: false,
                },
                chart: {
                    type: "bar",
                    height: 300,
                },
                fill: {
                    opacity: 1,
                },
                plotOptions: {},
                series: [
                    {
                        name: "المبيعات",
                        data: salesSeries, // Use dynamic sales data
                    },
                ],
                colors: "#435ebe",
                xaxis: {
                    categories: monthLabels, // Dynamic month names in Arabic
                },
                tooltip: {
                y: {
                    formatter: function (value) {
                        return value + ' مبيعات';
                    }
                },
                x: {
                    formatter: function (value) {
                        return value; // Month label
                    }
                }},
            };

            // Render the chart
            var chartProfileVisit = new ApexCharts(
                document.querySelector("#chart-profile-visit"),
                optionsProfileVisit
            );
            chartProfileVisit.render();
        });
    </script>

@endsection
