@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="py-5 row justify-content-center">
            <div class="col-md-8 col-lg-6">

                @if (\Session::has('message'))

                    <div class="alert alert-{{\Session::get('status')}} my-4">
                        {{\Session::get('message')}}
                    </div>

                @endif

                <form class="card my-card shadow" action="{{route('group.create')}}" method="post">

                    @csrf

                    <div class="card-body py-4">

                        <h3 class="card-title text-center mb-4">
                            <i class="fas fa-users fa-fw me-2"></i>
                            {{$group['class_name']}}
                        </h3>

                        <hr class="my-4">

                        <div class="info-text">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-hashtag fa-fw me-2"></i>
                                رقم الشعبة النظري:
                                <span class="fw-bold me-2">{{$group['class_number']}}</span>
                            </div>
                            @if($group['class_number_practical'] != null)
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-hashtag fa-fw me-2"></i>
                                    رقم الشعبة العملي:
                                    <span class="fw-bold me-2">{{$group['class_number_practical']}}</span>
                                </div>
                            @endif

                            @if($group['note'] != null)

                                <div class="alert alert-warning mt-4">
                                    <i class="fas fa-exclamation-circle fa-fw me-2"></i>
                                    {{$group['note']}}
                                </div>

                            @endif
                        </div>

                        <hr class="my-4">

                        <div class="text-center">
                            <a href="{{$group['group_url']}}" target="_blank" class="btn btn-primary">
                                زيارة المجموعة
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <a href="{{route('group.showEditForm',$group['class_number'])}}" class="btn btn-warning">
                                طلب تعديل
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reportModal">
                                ابلاغ
                                <i class="fas fa-exclamation-triangle"></i>
                            </button>
                        </div>
                    </div>
{{--                    <div class="card-footer text-center bg-transparent">--}}

{{--                    </div>--}}


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
