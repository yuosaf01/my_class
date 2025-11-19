@extends('layouts.dashboard')
@section('groups','active')

@section('dashboard_content')
    <div class="card my-card">
        <div class="card-body">
            <h2 class="p-2">مراجعة المجموعات</h2>
            <div class="row">

                @if (\Session::has('message'))

                    <div class="col-12">
                        <div class="alert alert-success">
                            {{\Session::get('message')}}
                        </div>
                    </div>

                @endif

                @if(count($groups) > 0)
                    @foreach($groups as $group)
                        <div class="col-12 col-md-6">

                            <div class="card m-2">
                                <div class="card-body">
                                    <p>
                                        اسم المجموعة: <span class="card-text">{{$group['class_name']}}</span>
                                    </p>
                                    <p>
                                        رقم الشعبة: <span class="card-text">{{$group['class_number']}}</span>
                                    </p>
                                    @if(isset($group['class_number_practical']))
                                        <p>
                                            رقم الشعبة العملي: <span class="card-text">{{$group['class_number_practical']}}</span>
                                        </p>
                                    @endif
                                    <p>
                                        رابط المجموعة: <span class="card-text"><a href="{{$group['group_url']}}" class="btn btn-link">{{$group['group_url']}}</a></span>
                                    </p>
                                    <p>
                                        الملاحظة: <span class="card-text">{{$group['note']}}</span>
                                    </p>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="{{ route('group.accept', $group['class_number']) }}"
                                       onclick="event.preventDefault();if(confirm('هل انت متأكد ؟')){document.getElementById('accept-form-{{$group['class_number']}}').submit()}"
                                       class="btn btn-success">
                                        قبول المجموعة
                                    </a>

                                    <a href="{{ route('group.delete', $group['class_number']) }}"
                                       onclick="event.preventDefault();if(confirm('هل انت متأكد ؟')){document.getElementById('delete-form-{{$group['class_number']}}').submit()}"
                                       class="btn btn-danger">
                                        حذف المجموعة
                                    </a>

                                    <form id="accept-form-{{$group['class_number']}}" action="{{ route('group.accept', $group['class_number']) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    <form id="delete-form-{{$group['class_number']}}" action="{{ route('group.delete', $group['class_number']) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info">
                            لايوجد مجموعات جديدة
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
