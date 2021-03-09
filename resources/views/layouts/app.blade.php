<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'mmmm_lemon') }}</title>

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
</head>
<body>
    <div id="app">
        <ul class="nav justify-content-center font18pt" style="margin-top:15px;">
            <li class="nav-item">
              <router-link class="nav-link active" aria-current="page" to="/">Home</a>
            </li>
            <li class="nav-item">
                <router-link class="nav-link active" aria-current="page" to="/about">About</a>
            </li>
        </ul>
        
        <main class="col-12 vh-100">
            @yield('content')
        </main>
    </div>
</body>
</html>


