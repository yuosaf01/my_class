<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create($class_number,Request $request) {

        $group = Group::where('class_number', $class_number)->first();

        if ($group) {
            $data = [];
            if (isset($request['note'])) {
                $data['note'] = $request['note'];
            }
            if ($group->reports()->create($data)) {

                return redirect()->back()->with(['message' => 'تم الابلاغ سيتم مراجعة المجموعة، شكرا لحرصك','status' => 'success']);

            }
        }
        
        return redirect()->back()->with(['message' => 'حدث خطا','status' => 'danger']);

    }

    public function delete($id) {
        $report = Report::find($id);
        Report::where('class_number', $report->class_number)->delete();
        Group::where('class_number', $report->class_number)->delete();
        return redirect()->back()->with(['message' => 'تم حذف المجموعة','status' => 'success']);
    }

    public function ignore($id) {
        $report = Report::find($id);
        $report->delete();
        return redirect()->back()->with(['message' => 'تم تجاهل الابلاغ','status' => 'success']);
    }

}
