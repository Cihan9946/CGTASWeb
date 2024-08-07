<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mazer Admin Dashboard</title>
    <link rel="stylesheet" href="{{asset('panel/assets/css/main/app.css')}}">
    <link rel="stylesheet" href="{{asset('panel/assets/css/pages/auth.css')}}">
    <link rel="shortcut icon" href="{{asset('panel/assets/images/logo/favicon.svg')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('panel/assets/images/logo/favicon.png')}}" type="image/png">
</head>

<body>
<div id="auth">

    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="{{route('login.get')}}"><img src="{{asset('panel/assets/images/logo/symposium.png')}}" alt="Logo"></a>
                </div>
                <h1 class="auth-title">Giriş.</h1>
                <p class="auth-subtitle mb-5">Adınıza oluşturulan verilerle giriş yapınız.</p>

                <form action="{{route('login.post')}}" method="post">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" name="email" class="form-control form-control-xl" placeholder="E-mail">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="password" class="form-control form-control-xl" placeholder="Şifre">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="form-check form-check-lg d-flex align-items-end">
                        <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label text-gray-600" for="flexCheckDefault">
                            Giriş bilgilerini kaydet.
                        </label>
                    </div>
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Giriş Yap</button>
                </form>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>

</div>
</body>

</html>
