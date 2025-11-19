@extends('layouts.dashboard')
@section('reports','active')

@section('dashboard_content')
    <div class="card my-card">
        <div class="card-body">
            <h2 class="p-2">مراجعة البلاغات</h2>
            <div class="row">


                @if (\Session::has('message'))

                    <div class="col-12">
                        <div class="alert alert-success">
                            {{\Session::get('message')}}
                        </div>
                    </div>

                @endif


                @if(count($reports) > 0)
                    @foreach($reports as $report)
                        @php($group = App\Models\Group::where('class_number','=',$report['class_number'])->first())
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

                                    @if($report['note'] != null)

                                        <p>
                                            سبب الابلاغ: <span class="card-text">{{$report['note']}}</span>
                                        </p>

                                    @endif

                                </div>
                                <div class="card-footer text-center">

                                    <a href="{{ route('report.ignore', $report['id']) }}"
                                       onclick="event.preventDefault();if(confirm('هل انت متأكد ؟')){document.getElementById('ignore-form-{{$report['id']}}').submit()}"
                                       class="btn btn-warning">
                                        تجاهل البلاغ
                                    </a>
                                    <form id="ignore-form-{{$report['id']}}" action="{{ route('report.ignore', $report['id']) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    
                                    <a href="{{ route('report.delete', $report['id']) }}"
                                       onclick="event.preventDefault();if(confirm('هل انت متأكد ؟')){document.getElementById('delete-form-{{$report['id']}}').submit()}"
                                       class="btn btn-danger">
                                        حذف المجموعة
                                    </a>

                                    <form id="delete-form-{{$report['id']}}" action="{{ route('report.delete', $report['id']) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info">
                            لايوجد بلاغات جديدة
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
