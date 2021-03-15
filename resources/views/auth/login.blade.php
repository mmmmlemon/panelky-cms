@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-11 text-center mt-5 borderUnderline">
            <h1>Login</h1>
        </div>
        <form class="col-12 col-md-6" method="POST" action="{{ route('login') }}">
            @csrf

            {{-- E-Mail --}}
            <div class="form-group col-12">
                <h5 class="text-center mt-5">
                    {{ __('E-Mail Address') }}
                </h5>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="bi bi-at"></i></div>
                    </div>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
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

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="bi bi-key"></i></div>
                    </div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            {{-- Remember Me --}}
            <div class="form-group row">
                <div class="col-md-6 offset-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            {{-- Login button --}}
            <div class="form-group row mb-0">
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-light btn-lg btn-block">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
