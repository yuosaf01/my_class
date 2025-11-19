@extends('layouts.app')
@section('dashboard','active')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="list-group">
{{--                    <a class="list-group-item list-group-item-action @yield('statistics')" href="{{route('dashboard.statistics')}}" id="statistics-list">الاحصائيات</a>--}}
                    <a class="list-group-item list-group-item-action @yield('groups')" href="{{route('dashboard.groups')}}" id="groups-list">
                        <span>المجموعات</span>
                        @if($counts['groups'] > 0)
                            <span class="badge bg-danger rounded-pill" style="float: left">{{$counts['groups']}}</span>
                        @endif
                    </a>
                    <a class="list-group-item list-group-item-action @yield('reports')" href="{{route('dashboard.reports')}}" id="reports-list">

                        <span>البلاغات</span>
                        @if($counts['reports'] > 0)
                            <span class="badge bg-danger rounded-pill" style="float: left">{{$counts['reports']}}</span>
                        @endif

                    </a>
                    <a class="list-group-item list-group-item-action @yield('editRequests')" href="{{route('dashboard.editRequests')}}" id="editRequests-list">

                        <span>طلبات التعديل</span>
                        @if($counts['editRequests'] > 0)
                            <span class="badge bg-danger rounded-pill" style="float: left">{{$counts['editRequests']}}</span>
                        @endif

                    </a>
                    @if(auth()->user()->is_super_admin())
                        <a class="list-group-item list-group-item-action @yield('admins')" href="{{route('dashboard.admins')}}" id="admins-list">المشرفين</a>
                    @endif
                </div>
            </div>

            <div class="col-12 col-md-9 mt-4 mt-md-0">
                @yield('dashboard_content')
            </div>
        </div>
    </div>
@endsection
