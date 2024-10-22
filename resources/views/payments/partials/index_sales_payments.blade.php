<!-- Basic Tables start -->
<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                دفعات المبيعات
            </h5>
            @can('payment-create')
            <a href="{{ route('payments.create') }}" class="btn icon btn-success"><span>إضافة</span></a>
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
            <div id="loading-spinner2" style="display: none; text-align: center; padding: 20px;">
                <div id="loading-spinner" style="display: none; text-align: center; padding: 20px;">
                    <img src="{{ asset('assets/compiled/svg/puff.svg') }}" class="me-4" style="width: 3rem" alt="audio">
                </div>
            </div>
            <div id="secondary-table" style="display: none;">
                <div class="table-responsive">
                    <table class="table" id="table11" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">رقم التعريف</th>
                                <th style="text-align: center;">المبيعة</th>
                                <th style="text-align: center;">العميل</th>
                                <th style="text-align: center;">المبلغ النهائي</th>
                                <th style="text-align: center;">المبلغ المدفوع</th>
                                <th style="text-align: center;">المبلغ المتبقي</th>
                                <th style="text-align: center;">تاريخ التسجيل</th>
                                <th style="text-align: center;">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($salesPayments->isEmpty())
                                <tr>
                                    <td>لم يتم تسجيل أي دفعات من طرف العملاء بعد</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @else
                            @foreach ($salesPayments as $payment)
                                    <tr>
                                        <td>{{ $payment['payment_id'] }}</td>
                                        <td>المبيعة {{ $payment['sale']->id }}</td>
                                        <td>{{ $payment['sale']->customer->name }}</td>
                                        <td>{{ $payment['sale']->final_price }}</td>
                                        <td>{{ $payment['sale']->total_paid }}</td>
                                        <td>
                                            @if(($payment['sale']->final_price - $payment['sale']->total_paid) == 0)
                                                <span class="badge bg-light-success">تم الدفع كليا</span>
                                            @else
                                                {{ $payment['sale']->final_price - $payment['sale']->total_paid }}
                                            @endif
                                        </td>
                                        <td>{{ $payment['created_at'] }}</td>
                                        <td>
                                            <div class="button-group">
                                                @can('payment-show')
                                                <a href="{{ route('payments.customShow', ['paymentType' => 'sale', 'payment' => $payment['payment_id']]) }}" class="btn btn-outline-primary">عرض</a>
                                                @endcan
                                                @can('payment-edit')
                                                <a href="{{ route('payments.customEdit', ['id' => $payment['payment_id']]) }}" class="btn btn-outline-primary">تعديل</a>
                                                @endcan
                                                @can('payment-delete')
                                                    <!-- Trigger button for modal -->
                                                    <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $payment['payment_id'] }}">
                                                        حذف
                                                    </button>

                                                    <!-- Delete form (submitted via modal) -->
                                                    <form action="{{ route('payments.customDestroy', ['paymentType' => 'sale', 'payment' => $payment['payment_id']]) }}" method="POST" id="delete-form-{{ $payment['payment_id'] }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>

                                                    <!-- Include the delete modal -->
                                                    @include('partials.delete-modal', ['id' => $payment['payment_id']])
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