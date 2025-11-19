@extends('layouts.dashboard')
@section('admins','active')

@section('dashboard_content')

    <div class="card my-card">
        <div class="card-body">
            <h2 class="p-2 mb-3">اضافة مشرف جديد</h2>

            @if (\Session::has('add-message'))

                <div class="alert alert-{{\Session::get('status')}}">
                    {{\Session::get('add-message')}}
                </div>

            @endif

            <form action="{{route('admins.add')}}" method="post">

                @csrf

                <div class="row g-3">
                    <div class="col-md-9">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="البريد الالكتروني">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100">
                            اضافة
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="card my-card mt-4">
        <div class="card-body">
            <h2 class="p-2 mb-3">المشرفين الحاليين</h2>

            @if (\Session::has('remove-message'))

                <div class="alert alert-{{\Session::get('status')}}">
                    {{\Session::get('remove-message')}}
                </div>

            @endif

            @if(count($admins) > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">الاسم</th>
                        <th scope="col">البريد الالكتروني</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $user)

                            <tr>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['email']}}</td>
                                <td>
                                    <a class="btn btn-danger"
                                       href="#delete-{{$user['id']}}"
                                       onclick="event.preventDefault();if(confirm('هل انت متأكد ؟')){document.getElementById('delete-from-{{$user['id']}}').submit()}">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>

                                    <form id="delete-from-{{$user['id']}}" action="{{ route('admins.delete') }}" method="POST" class="d-none">
                                        @csrf
                                        <input type="hidden" name="email" value="{{$user['email']}}">
                                    </form>
                                </td>
                            </tr>


                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">
                    لايوجد مشرفين آخرين
                </div>
            @endif
        </div>
    </div>
@endsection
