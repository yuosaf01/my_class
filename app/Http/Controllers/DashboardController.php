<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\Report;
use App\Models\RequestEdit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    function index() {

//        $groups = Group::where('accepted', '=', 0)->count();
//        $reports = Report::count();
//        $requests = RequestEdit::where('accepted','=',0)->count();


        return view('dashboard.dashboard');

    }

    private function getCounts() {
        $groups = Group::where('accepted', '=', 0)->count();
        $reports = Report::count();
        $requests = RequestEdit::where('accepted','=',0)->count();

        return ['groups'=>$groups,'reports'=>$reports,'editRequests'=>$requests];
    }

    function groups() {
        $groups = Group::where('accepted', '=', 0)->get();
        return view('dashboard.groups',['groups' => $groups,'counts' => $this->getCounts()]);
    }
    function reports() {
        $reports = Report::all();
        return view('dashboard.reports',['reports' => $reports,'counts' => $this->getCounts()]);
    }
    function statistics() {
        return view('dashboard.statistics');
    }
    function editRequests() {
        $requests = RequestEdit::where('accepted','=',0)->get();
        return view('dashboard.editRequests',['requests' => $requests,'counts' => $this->getCounts()]);
    }
    function admins() {
        $admins = User::where('role', '=', 'admin')->get();
        return view('dashboard.admins',['admins' => $admins,'counts' => $this->getCounts()]);
    }
}
