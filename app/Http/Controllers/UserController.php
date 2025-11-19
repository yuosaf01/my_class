<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware(['auth','verified']);
    }

    public function profile() {

        $user = Auth::user();

        return view('user.profile',['user' => $user]);
    }

    public function update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.auth()->id()],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $user = User::where('id','=',auth()->id())->first();
        $user->name = $request['name'];
        if ($user->email != $request['email']) {
            $user->email_verified_at = null;
        }
        $user->email = $request['email'];
        $user->save();

        return redirect()->back()->with([
            'message' => 'تم تعديل البيانات بنجاح',
            'status' => 'info',
        ])->withInput($request->all());

    }

}
