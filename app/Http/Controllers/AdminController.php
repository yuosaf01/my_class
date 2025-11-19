<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class AdminController extends Controller {

    public function __construct() {
        $this->middleware(['auth','super_admin']);
    }

    public function add(Request $request){

        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email']
            ],
            [
                '*.required' => 'لايمكن ترك هذا الحقل فارغاً',
                '*.string' => 'يجب ادخال نص',
                '*.min' => 'الحد الادنى حرف واحد',
                '*.max' => 'الحد الاعلى 255 حرف',
                '*.email' => 'يجب ادخال بريد الكتروني صحيح',
                '*.unique' => 'هذا البريد الالكتروني مسجل سابقا'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $newAdmin = User::create([
            'name' => 'Admin',
            'email' => $request->email,
            'role' => 'admin',
            'password' => Hash::make($this->generateRandomString())
        ]);
        

        if ($newAdmin != null) {
            return redirect()->back()->with(['add-message' => 'تم انشاء الحساب' ,'status' => 'success']);
        }

        return redirect()->back()->with(['add-message' => 'المستخدم غير موجود' ,'status' => 'danger']);

    }

    public function delete(Request $request) {

        $res = $this->set_role($request,'user');

        if ($res['completed']) {
            return redirect()->back()->with(['remove-message' => 'تم ازالة '.$res['user']['name'].' من الاشراف' ,'status' => 'success']);
        }

        return redirect()->back()->with(['remove-message' => 'المستخدم غير موجود' ,'status' => 'danger']);

    }

    private function set_role($request, $role) {
        if (isset($request['email'])) {
            $user = User::where('email', $request['email'])->first();
            if ($user) {
                $user->role = $role;
                $user->save();
                return ['completed' => true,'user' => $user];
            }
        }
        return ['completed' => false,'user' => null];
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
