@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="py-5 row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <form class="card my-card shadow" action="{{route('group.edit',$group['class_number'])}}" method="post">

                    @csrf

                    <div class="card-body">
                        <h3 class="mb-4">تعديل رابط مجموعة</h3>

                        @if (\Session::has('message'))

                            <div class="alert alert-{{\Session::get('status')}} my-4">
                                {{\Session::get('message')}}
                            </div>

                        @endif

                        @include('group.form', ['btn_title' => 'ارسال', 'btn_class' => 'primary','action' => 'edit'])


                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
