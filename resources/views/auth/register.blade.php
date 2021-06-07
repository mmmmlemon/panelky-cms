<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Регистрация</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animations.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
</head>
<body class="animatedBackgroundAdmin">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 text-center mt-5 borderUnderline">
                <h1>Register</h1>
            </div>

            <form class="col-12 col-md-6" method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Username --}}
                <div class="form-group col-12">
                    <h5 class="text-center mt-5">
                        {{ __('Username') }}
                    </h5>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        <div class="input-group-text"><i class="bi bi-person"></i></div>
                        </div>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- E-Mail --}}
                <div class="form-group col-12">
                    <h5 class="text-center mt-1">
                        {{ __('E-Mail') }}
                    </h5>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="bi bi-at"></i></div>
                        </div>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group col-12">
                    <h5 class="text-center mt-1">
                        {{ __('Password') }}
                    </h5>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="bi bi-key"></i></div>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- Confirm password --}}
                <div class="form-group col-12">
                    <h5 class="text-center mt-1">
                        {{ __('Confirm password') }}
                    </h5>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="bi bi-key"></i></div>
                        </div>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-light btn-lg btn-block">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>


