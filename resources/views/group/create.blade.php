@extends('layouts.app')
@section('showCreateForm','active')

@section('content')
<div class="container">
    <div class="py-5 row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <form class="card my-card shadow p-2" action="{{route('group.create')}}" method="post">

                @csrf

                <div class="card-body">
                    <h3 class="mb-4 p-3 text-center">إضافة رابط مجموعة جديدة</h3>


                    @if (\Session::has('message'))

                        <div class="my-4 text-center">

                            <div class="alert alert-{{\Session::get('status')}}">
                                {{\Session::get('message')}}

                                @if (\Session::has('url'))

                                    <a class="btn btn-link" href="{{\Session::get('url')}}">
                                        {{\Session::get('url')}}
                                    </a>

                                @endif

                            </div>

                        </div>

                    @endif


                    @include('group.form', ['btn_title' => 'إضافة', 'btn_class' => 'success','action' => 'create'])
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
