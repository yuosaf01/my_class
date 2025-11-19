@extends('layouts.app')
@section('home','active')

@section('content')
<div class="container">
    <div class="py-5 row justify-content-center text-center">
        <div class="col-md-8 col-lg-6">

            <h2 class="p-1">شعبتي</h2>
            <p class="p-2 pb-3">
                ابحث عن رابط مجموعة شعبتك أو أضف رابط جديد في حال لم يكن مسجلاً
            </p>

            <form class="card my-card shadow" action="{{route('group.search')}}" method="post">

                @csrf

                <div class="card-body pt-4 mt-2 px-3 px-md-5">

                    <div class="row g-3">
                        <div class="col-12">
                            <input type="number" name="number" class="form-control" required placeholder="أدخل رقم الشعبة">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100">
                                بحث
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 text-center">

                        @if (\Session::has('message'))

                            <div class="alert alert-{{\Session::get('status')}}">
                                {{\Session::get('message')}}

                                @if (\Session::has('url'))

                                    <a class="btn btn-link" href="{{\Session::get('url')}}">
                                        اضافة
                                    </a>

                                @endif

                            </div>

                        @endif

                    </div>

                </div>

            </form>


        </div>
        <div class="col-12"></div>
        <div class="col-md-8 col-lg-6">
            <div class="card my-card shadow border-0 rounded-4 mt-5">
                <div class="card-body px-4 py-4 text-center">

                    <div class="row text-center">
                        <div class="col-6 col-md-3 mb-3">
                            <div class="fs-3 fw-bold">{{$searchCounter}}</div>
                            <div class="text-muted small">عمليات بحث</div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="fs-3 fw-bold">{{$groupCount}}</div>
                            <div class="text-muted small">شعبة</div>
                        </div>
                        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
                            <div class="text-muted small mb-1">آخر بحث: <span class="fw-medium">{{$lastSearch}}</span></div>
                            <div class="text-muted small">آخر إضافة: <span class="fw-medium">{{$lastCreateGroup}}</span></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
