@extends('layouts.app')
@section('login','active')
@section('content')
<div class="container">
    <div class="py-5 row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3>تسجيل دخول</h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-12 col-form-label">البريد الالكتروني:</label>

                            <div class="col-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-12 col-form-label">كلمة السر:</label>

                            <div class="col-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 offset-12">
                                <a href="{{route('password.request')}}">هل نسيت كلمة السر ؟</a>
                            </div>
                        </div>
                        {{--                        <div class="row mb-3">--}}
{{--                            <div class="col-12 offset-12">--}}

{{--                                <div class="form-check d-inline">--}}

{{--                                    <label class="form-check-label" for="remember">--}}
{{--                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}
{{--                                        <span>تذكرني</span>--}}

{{--                                    </label>--}}


{{--                                </div>--}}


{{--                            </div>--}}
{{--                        </div>--}}

                        <input type="hidden" name="remember" checked>

                        <div class="row mb-0">
                            <div class="col-12 offset-12">
                                <button type="submit" class="btn btn-primary">
                                    دخول
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
