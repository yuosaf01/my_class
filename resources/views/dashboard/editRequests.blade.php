@extends('layouts.dashboard')
@section('editRequests','active')

@section('dashboard_content')
    <div class="card my-card">
        <div class="card-body">
            <h2 class="p-2">طلبات التعديل</h2>
            <div class="row">

                @if (\Session::has('message'))

                    <div class="col-12">
                        <div class="alert alert-success">
                            {{\Session::get('message')}}
                        </div>
                    </div>

                @endif

                @if(count($requests) > 0)
                    @foreach($requests as $request)
                        @php
                            $group = App\Models\Group::where('id','=',$request['group_id'])->first();
                            $color = 'background-color: rgba(255,255,0,0.5)';
                            $edited = [
                                'class_number' => ($group['class_number'] != $request['class_number']) ? $color : '',
                                'class_number_practical' => ($group['class_number_practical'] != $request['class_number_practical']) ? $color : '',
                                'class_name' => ($group['class_name'] != $request['class_name']) ? $color : '',
                                'group_url' => ($group['group_url'] != $request['group_url']) ? $color : '',
                                'note' => ($group['note'] != $request['note']) ? $color : '',
                            ];
                        @endphp
                        <div class="col-12">

                            <div class="card m-2">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <p class="card-text"><b>المعلومات القديمة</b></p>
                                            <p>
                                                رقم الشعبة النظري: <span class="card-text">{{$group['class_number']}}</span>
                                            </p>
                                            @if(isset($group['class_number_practical']))
                                                <p>
                                                    رقم الشعبة العملي: <span class="card-text">{{$group['class_number_practical']}}</span>
                                                </p>
                                            @endif
                                            <p>
                                                اسم المجموعة: <span class="card-text">{{$group['class_name']}}</span>
                                            </p>
                                            <p>
                                                رابط المجموعة: <span class="card-text"><a href="{{$group['group_url']}}" class="btn btn-link">{{$group['group_url']}}</a></span>
                                            </p>
                                            <p>
                                                الملاحظة: <span class="card-text">{{$group['note']}}</span>
                                            </p>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <p class="card-text"><b>المعلومات الجديدة</b></p>
                                            <p style="{{$edited['class_number']}}">
                                                رقم الشعبة النظري: <span class="card-text">{{$request['class_number']}}</span>
                                            </p>
                                            @if(isset($request['class_number_practical']))
                                                <p style="{{$edited['class_number_practical']}}">
                                                    رقم الشعبة العملي: <span class="card-text">{{$request['class_number_practical']}}</span>
                                                </p>
                                            @endif
                                            <p style="{{$edited['class_name']}}">
                                                اسم المجموعة: <span class="card-text">{{$request['class_name']}}</span>
                                            </p>
                                            <p style="{{$edited['group_url']}}">
                                                رابط المجموعة: <span class="card-text"><a href="{{$request['group_url']}}" class="btn btn-link">{{$request['group_url']}}</a></span>
                                            </p>
                                            <p style="{{$edited['note']}}">
                                                الملاحظة: <span class="card-text">{{$request['note']}}</span>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer text-center">

                                    <a href="{{ route('request.accept', $request['id']) }}"
                                       onclick="event.preventDefault();if(confirm('هل انت متأكد ؟')){document.getElementById('accept-form-{{$request['id']}}').submit()}"
                                       class="btn btn-success">
                                        قبول التعديل
                                    </a>
                                    <form id="accept-form-{{$request['id']}}" action="{{ route('request.accept', $request['id']) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    
                                    <a href="{{ route('request.ignore', $request['id']) }}"
                                       onclick="event.preventDefault();if(confirm('هل انت متأكد ؟')){document.getElementById('ignore-form-{{$request['id']}}').submit()}"
                                       class="btn btn-warning">
                                        تجاهل التعديل
                                    </a>

                                    <form id="ignore-form-{{$request['id']}}" action="{{ route('request.ignore', $request['id']) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info">
                            لايوجد طلبات تعديل جديدة
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
