<!-- Basic Tables start -->
<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                دفعات المشتريات
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
                                <th style="text-align: center;">الماشية</th>
                                <th style="text-align: center;">المورد</th>
                                <th style="text-align: center;">المبلغ الإجمالي</th>
                                <th style="text-align: center;">المبلغ المدفوع</th>
                                <th style="text-align: center;">المبلغ المتبقي</th>
                                <th style="text-align: center;">تاريخ التسجيل</th>
                                <th style="text-align: center;">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($purchasePayments->isEmpty())
                                <tr>
                                    <td>لم يتم تسجيل أي دفعات لحساب الموردين بعد</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @else
                            @foreach ($purchasePayments as $payment)
                                    <tr>
                                        {{-- <td>{{ $payment['id'] }}</td> --}}
                                        <td>{{ $payment['payment_id'] }}</td>
                                        <td>{{ $payment['animal']->type }} {{ $payment['animal']->id }} ({{ $payment['animal']->weight }} كجم)</td>
                                        <td>{{ $payment['animal']->supplier->name }}</td>
                                        <td>{{ $payment['animal']->total_price }}</td>
                                        <td>{{ $payment['animal']->total_paid }}</td>
                                        <td>{{ $payment['animal']->total_price - $payment['animal']->total_paid }}</td>
                                        <td>{{ $payment['created_at'] }}</td>
                                        <td>
                                            <div class="button-group">
                                                @can('payment-show')
                                                <a href="{{ route('payments.customShow', ['paymentType' => 'purchase', 'payment' => $payment['payment_id']]) }}" class="btn btn-outline-primary">عرض</a>
                                                @endcan
                                                @can('payment-edit')
                                                <a href="{{ route('payments.customEdit', ['id' => $payment['payment_id']]) }}" class="btn btn-outline-primary">تعديل</a>
                                                @endcan
                                                @can('payment-delete')
                                                    <!-- Trigger button for modal -->
                                                    <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $payment['payment_id'] }}">
                                                        حذف
                                                    </button>

                                                    <!-- Delete form (will be submitted via the modal) -->
                                                    <form action="{{ route('payments.customDestroy', ['paymentType' => 'purchase', 'payment' => $payment['payment_id']]) }}" method="POST" id="delete-form-{{ $payment['payment_id'] }}" class="d-inline">
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