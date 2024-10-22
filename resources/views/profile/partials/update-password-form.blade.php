<div class="card-body">
    <form class="form form-horizontal" method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')
        <div class="form-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="first-name-horizontal-icon">كلمة المرور الحالية</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-icon-left">
                        <div class="position-relative">
                            <input id="update_password_current_password" name="current_password" type="password"
                             autocomplete="current-password" class="form-control" placeholder="كلمة المرور الحالية">
                             @error('current_password')
                             <div class="text-danger mt-2">
                                 {{ $message }}
                             </div>
                             @enderror 
                             {{-- <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-danger mt-1" /> --}}
                            <div class="form-control-icon">
                                <i class="bi bi-key"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="email-horizontal-icon">كلمة المرور الجديدة</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-icon-left">
                        <div class="position-relative">
                            <input id="update_password_password" name="password" type="password" class="form-control" 
                            placeholder="كلمة المرور الجديدة" autocomplete="new-password">
                            @error('password')
                            <div class="text-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                            {{-- <x-input-error :messages="$errors->updatePassword->get('password')" class="text-danger mt-1" /> --}}
                            <div class="form-control-icon">
                                <i class="bi bi-key"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="email-horizontal-icon">تأكيد كلمة المرور</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-icon-left">
                        <div class="position-relative">
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                            placeholder="تأكيد كلمة المرور" class="form-control" autocomplete="new-password">
                            @error('password_confirmation')
                            <div class="text-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                            {{-- <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-danger mt-1" /> --}}
                                <div class="form-control-icon">
                                <i class="bi bi-key"></i>
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
