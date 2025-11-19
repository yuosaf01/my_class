@extends('layouts.app')
@section('profile','active')

@section('content')
    <div class="container">
        <div class="py-5 row justify-content-center">
            <div class="col-md-12 col-lg-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h3>بيانات المستخدم</h3>

                        @if (\Session::has('message'))

                            <div class="my-4 text-center">

                                <div class="alert alert-{{\Session::get('status')}}">
                                    {{\Session::get('message')}}
                                </div>

                            </div>

                        @endif

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-12 col-form-label">الاسم:</label>

                                <div class="col-12">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ (old('name') != null) ? old('name') : $user['name'] }}" required>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-12 col-form-label">البريد الالكتروني:</label>

                                <div class="col-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ (old('email') != null) ? old('email') : $user['email'] }}" required>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-12 offset-12">
                                    <button type="submit" class="btn btn-primary">
                                        حفظ
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
