<div class="card-body">
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <form class="form form-horizontal" method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')
        <div class="form-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="first-name-horizontal-icon">المستخدم</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-icon-left">
                        <div class="position-relative">
                            <input id="name" name="name" type="text" class="form-control" placeholder="الاسم"
                            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                @if ($errors->get('name'))
                                <div class="text-danger mt-1">
                                    @foreach ($errors->get('name') as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                                @endif
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="email-horizontal-icon">البريد الإلكتروني</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-icon-left">
                        <div class="position-relative">
                            <input class="form-control" placeholder="البريد الإلكتروني"
                            id="email" name="email" type="email"
                            value="{{ old('email', $user->email) }}" required autocomplete="username">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-1 mb-1">حفظ التعديلات</button>
                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-muted mb-0"
                        >{{ __('تم الحفظ.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
