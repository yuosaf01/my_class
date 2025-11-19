<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\RequestEdit;
use Illuminate\Support\Facades\Validator;

class RequestEditController extends Controller
{
    function showEdit($class_number) {
        $group = Group::where('class_number', $class_number)->firstOrFail();
        return view('group.edit', ['group' => $group]);
    }

    function edit($class_number,Request $request) {
        $group = Group::where('class_number', $class_number)->firstOrFail();

        $regex = '/^(https?:\/\/)?(www\.)?(chat\.whatsapp\.com\/[\w-]+|(t\.me|telegram\.me)\/(joinchat\/[\w-]+|[\w-]+))$/';

        $rules = [
            'class_number' => ['required','numeric','min:1','max:999999','unique:groups,id,'.$group['id']],
            'class_name' => ['required','string','min:1','max:255'],
            'group_url' => ['required','string','min:1','max:255','regex:'.$regex,'unique:groups,id,'.$group['id']],
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

        if ($request['practical_checkbox'] || isset($rules['class_number_practical'])) {
            $rules['class_number_practical'] = ['required','nullable','numeric','min:1','max:999999','sometimes','unique:groups,id,'.$group['id']];
        }

        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        if ($request['class_name'] == $group->class_name &&
            $request['group_url'] == $group->group_url &&
            $request['class_number'] == $group->class_number &&
            $request['class_number_practical'] == $group->class_number_practical &&
            $request['note'] == $group->note) {

            return redirect()->back()->with(['message' => 'لم يتم تغيير اي معلومات','status' => 'danger']);

        }

        $data = [
            'class_name' => $request['class_name'],
            'class_number' => $request['class_number'],
            'class_number_practical' => $request['class_number_practical'],
            'group_url' => $request['group_url'],
        ];

        if ($request['note'] != null) {
            $data['note'] = $request['note'];
        }

        if ($group->requests()->create($data)) {

            return redirect()->back()->with(['message' => 'تم انشاء طلب التعديل، بانتظار المراجعة','status' => 'success']);

        }

        return redirect()->back()->with(['message' => 'حدث خطا','status' => 'danger']);


    }

    public function accept($id) {
        $requestEdit = RequestEdit::find($id);
        if ($requestEdit) {

            $group = Group::where('id', $requestEdit->group_id)->firstOrFail();

            $group->update([
                'class_name' => $requestEdit->class_name,
                'class_number' => $requestEdit->class_number,
                'group_url' => $requestEdit->group_url,
                'note' => $requestEdit->note,
            ]);

            $requestEdit->accepted = 1;
            $requestEdit->save();
        }
        return redirect()->back()->with(['message' => 'تم التعديل بنجاح','status' => 'success']);

    }

    public function ignore($id) {
        $requestEdit = RequestEdit::find($id);
        if ($requestEdit) {
            $requestEdit->accepted = 2;
            $requestEdit->save();
        }
        return redirect()->back()->with(['message' => 'تم تجاهل الطلب','status' => 'success']);
    }
}
