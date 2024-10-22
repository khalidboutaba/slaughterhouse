<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Slaughterhouse Management')</title>
    <link rel="icon" href="{{ asset('img/logo/Nadigit_logo.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.rtl.css') }}">
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ route('dashboard') }}">Nadigit-SMS</a>
                    </div>
                    <h1 class="auth-title">تسجيل الدخول</h1>

                    <!-- Laravel form handling -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl" placeholder="اسم المستخدم" required autofocus>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('email')
                            <div class="text-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl" placeholder="كلمة المرور" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                            <div class="text-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-center">
                            <input class="form-check-input ms-2" type="checkbox" name="remember" id="flexCheckDefault">
                            &nbsp;
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                تذكرني
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">تسجيل الدخول</button>
                    </form>
                    {{-- <div class="text-center mt-5 text-lg fs-4">
                        <p><a class="font-bold" href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>.</p>
                    </div> --}}
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>

    </div>
</body>

</html>
