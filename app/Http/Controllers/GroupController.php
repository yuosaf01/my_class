<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Settings;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class GroupController extends Controller
{

    public function create(Request $request) {

        $regex = '/^(https?:\/\/)?(www\.)?(chat\.whatsapp\.com\/[\w-]+|(t\.me|telegram\.me)\/(joinchat\/[\w-]+|[\w-]+))$/';

        $rules = [
            'class_number' => ['required','numeric','min:1','max:999999','unique:groups'],
            'class_name' => ['required','string','min:1','max:255'],
            'group_url' => ['required','string','min:1','max:255','unique:groups','regex:'.$regex],
        ];

        $messages = [
            '*.required' => 'لايمكن ترك هذا الحقل فارغاً',
            '*.string' => 'يجب ادخال نص',
            '*.numeric' => 'يجب ادخال رقم',
            '*.min' => 'الحد الادنى حرف واحد',
            '*.max' => 'الحد الاعلى 255 حرف',
            'class_number*.unique' => 'يوجد مجموعة مسجلة لهذة الشعبة',
            'class_number*.min' => 'يجب ان يكون رقم الشعبة 1 او اكثر',
            'class_number*.max' => 'يجب ان يكون رقم الشعبة اقل من 6 ارقام',
            'group_url.regex' => 'يجب ان يكون الرابط لمجموعة Whatsapp او Telegram',
            'group_url.unique' => 'يوجد شعبة مسجلة لهذا الرابط'
        ];

        if ($request['note'] != null) {
            $rules['note'] = 'required|string|min:1|max:255';
        }

        if ($request['practical_checkbox']) {
            $rules['class_number_practical'] = 'required|nullable|sometimes|unique:groups|min:1|max:255';
        }

        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'class_number' => $request['class_number'],
            'class_name' => $request['class_name'],
            'group_url' => $request['group_url'],
        ];

        if ($request['practical_checkbox']) {
            $data['class_number_practical'] = $request['class_number_practical'];

            $class_number_practical = Group::where('class_number', $request['class_number_practical'])->first();
            if ($class_number_practical != null) {

                return redirect()->back()->with([
                    'message' => 'يوجد شعبة نظرية بهذا الرقم '. $request['class_number_practical'] . 'يمكنك الدخول لها من هنا',
                    'status' => 'info',
                    'url' => route('group.show', ['class_number' => $class_number_practical->class_number])
                ])->withInput($request->all());

            }

        }

        $class_number = Group::where('class_number_practical', $request['class_number'])->first();
        if ($class_number != null) {

            return redirect()->back()->with([
                'message' => 'يوجد شعبة عملية بهذا الرقم '. $request['class_number'] . ' يمكنك الدخول لها من هنا',
                'status' => 'info',
                'url' => route('group.show', ['class_number' => $class_number->class_number])
            ])->withInput($request->all());

        }

        if ($request['note'] != null) {
            $data['note'] = $request['note'];
        }

        Settings::updateOrCreate([
            'key' => 'last_create_group',
        ],[
            'value' => Carbon::now()
        ]);

        $group = Group::create($data);

        return redirect()->route('group.show', ['class_number' => $group['class_number']]);

    }

    public function showCreate() {
        return view('group.create');
    }

    public function show($class_number) {
        $group = Group::where('class_number', $class_number)->firstOrFail();
        return view('group.show', ['group' => $group]);
    }
    public function search(Request $request) {

        if ($request->has('number')) {

            if ($request['number'] == null) {
                return redirect()->back()->with(['message' => 'يرجى ادخال رقم الشعبة', 'status' => 'danger']);
            }

            Settings::updateOrCreate([
                'key' => 'last_search',
            ],[
                'value' => Carbon::now()
            ]);

            $searchCounter = Settings::where('key', 'search_count')->first();

            Settings::updateOrCreate([
                'key' => 'search_count',
            ],[
                'value' => ($searchCounter != null) ? $searchCounter->value + 1 : 1
            ]);

            $group = Group::where('class_number','=',$request['number'])
                        ->orWhere('class_number_practical','=',$request['number'])
                        ->first();

            if ($group) {
                return redirect()->route('group.show', ['class_number' => $group['class_number']]);
            }

        }

        return redirect()->back()->with(['message' => 'لا يوجد مجموعة مسجلة، قم بتسجل المجموعة من هنا', 'status' => 'danger', 'url' => route('group.create')]);

    }
//    public function showEdit($class_number) {
//        $group = Group::where('class_number', $class_number)->firstOrFail();
//        return view('group.edit', ['group' => $group]);
//    }
//
//    public function edit($class_number,Request $request) {
//
//        $group = Group::where('class_number', $class_number)->firstOrFail();
//
//        $regex = '/^(https?:\/\/)?(www\.)?(chat\.whatsapp\.com\/[\w-]+|(t\.me|telegram\.me)\/(joinchat\/[\w-]+|[\w-]+))$/';
//
//        $rules = [
//            'class_name' => 'required|string|min:1|max:255',
//            'group_url' => 'required|string|min:1|max:255|unique:groups,id,'.$group['id'].'|regex:'.$regex,
//            'class_number' => ['required','numeric','min:1','max:999999','unique:groups,id,'.$group['id']],
//        ];
//
//        $messages = [
//            '*.required' => 'لايمكن ترك هذا الحقل فارغاً',
//            '*.string' => 'يجب ادخال نص',
//            '*.numeric' => 'يجب ادخال رقم',
//            '*.min' => 'الحد الادنى حرف واحد',
//            '*.max' => 'الحد الاعلى 255 حرف',
//            'class_number*.unique' => 'يوجد مجموعة مسجلة لهذة الشعبة',
//            'class_number*.min' => 'يجب ان يكون رقم الشعبة 1 او اكثر',
//            'class_number*.max' => 'يجب ان يكون رقم الشعبة اقل من 6 ارقام',
//            'group_url.unique' => 'يوجد شعبة مسجلة لهذا الرابط',
//            'group_url.regex' => 'يجب ان يكون الرابط لمجموعة Whatsapp او Telegram',
//        ];
//
//        if ($request['note'] != null) {
//            $rules['note'] = 'required|string|min:1|max:255';
//        }
//
//        if ($request['practical_checkbox']) {
//            $rules['class_number_practical'] = 'required|nullable|sometimes|min:1|max:255|unique:groups,id,'.$group['id'];
//        }
//
//        $validator = Validator::make($request->all(), $rules,$messages);
//
//        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator)->withInput($request->all());
//        }
//
//        $data = [
//            'class_name' => $request['class_name'],
//            'class_number' => $request['class_number'],
//            'group_url' => $request['group_url'],
//        ];
//
//        if ($request['note'] != null) {
//            $data['note'] = $request['note'];
//        }
//
//        $group->update($data);
//
//        return redirect()->route('group.show', ['class_number' => $group['class_number']]);
//
//    }

    function accept($class_number) {
        $group = Group::where('class_number', $class_number)->firstOrFail();
        $group->accepted = 1;
        $group->save();
        return redirect()->back()->with(['message' => 'تم القبول','status' => 'success']);
    }

    function delete($class_number) {
        $group = Group::where('class_number', $class_number)->firstOrFail();
        $group->delete();
        return redirect()->back()->with(['message' => 'تم الحذف','status' => 'success']);
    }

}
