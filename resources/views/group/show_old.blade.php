@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="py-5 row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <form class="card shadow" action="{{route('group.create')}}" method="post">

                    @csrf

                    <div class="card-body">
                        <h3 class="mb-4">{{$group['class_name']}}</h3>

                        <hr>

                        <div class="mt-4 text-center">

                            <p>رقم الشعبة: <span>{{$group['class_number']}}</span></p>

                            <p><span>{{$group['note']}}</span></p>


                        </div>

                        @if (\Session::has('message'))

                            <div class="alert alert-{{\Session::get('status')}} my-4">
                                {{\Session::get('message')}}
                            </div>

                        @endif

                    </div>
                    <div class="card-footer text-center">
                        <a href="{{$group['group_url']}}" class="btn btn-outline-primary">زيارة المجموعة</a>
                        <a href="{{route('group.showEditForm',$group['class_number'])}}" class="btn btn-outline-warning">طلب تعديل</a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#reportModal">
                            ابلاغ
                        </button>

                    </div>


                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('group.report',$group['class_number'])}}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel">الابلاغ عن مجموعة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea name="note" class="form-control" rows="3" placeholder="اكتب سبب الابلاغ ( اختياري )"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-warning">ابلاغ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
