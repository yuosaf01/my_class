<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Group;
use Carbon\Carbon;

class HomeController extends Controller {

    public function index() {

        $searchCounter = Settings::where('key', 'search_count')->first();

        $groupCount = Group::count();

        $lastSearch = Settings::where('key', 'last_search')->first();
        $lastSearchPast = '';
        if ($lastSearch != null) {
            $lastSearchDate = Carbon::parse($lastSearch->value);
            $lastSearchPast = $lastSearchDate->diffForHumans();
        }

        $lastCreateGroup = Settings::where('key', 'last_create_group')->first();
        $lastCreateGroupPast = '';
        if ($lastCreateGroup != null) {
            $lastCreateGroupDate = Carbon::parse($lastCreateGroup->value);
            $lastCreateGroupPast = $lastCreateGroupDate->diffForHumans();
        }

        return view('home',[
            'lastSearch' => $lastSearchPast,
            'lastCreateGroup' => $lastCreateGroupPast,
            'searchCounter' => ($searchCounter != null) ? $searchCounter->value : 0,
            'groupCount' => $groupCount,
        ]);
    }

    public function gpa() {
        return view('gpa');
    }

    public function absence() {
        return view('absence');
    }

    public function absence2() {
        return view('absence2');
    }

}
