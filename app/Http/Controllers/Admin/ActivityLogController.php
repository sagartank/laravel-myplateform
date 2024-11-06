<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use App\Exports\ActivityLogExport;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class ActivityLogController extends Controller
{
    public function index()
    {
        return view('admin.activity-log.index', [
            'events' => DB::table('activity_log')->select('event')->distinct()->pluck('event'),
            'subjectTypes' => DB::table('activity_log')->select('subject_type')->distinct()->pluck('subject_type'),
        ]);
    }

    public function ajaxShowActivityLog(Request $request)
    {
        $request->validate([
            'id' => ['required', 'numeric', 'integer'],
        ]);
        
        try {
            $activityLogSection = view('admin.activity-log.ajax.activity-log-section', [
                'activityLog' => Activity::find($request->input('id')),
            ])->render();
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'success' => 0,
                'status' => $th->getCode(),
                'message' => $th->getMessage(),
            ];
            return response()->json($response);
        }

        $response = [
            'success' => 1,
            'message' => 'Activity log shown successfully.',
            'activityLogSection' => $activityLogSection,
        ];
        return response()->json($response);
    }

    public function ajaxLoadActivityLogData(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string'],
            'event' => ['nullable', 'string'],
            'subject_type' => ['nullable', 'string'],
        ]);

        $params = $request->all();
        $perPage = $request->input('per_page') ?? 15;
        $sortType = $request->input('sort_type') ?? 'DESC';
        $sortColumn = $request->input('sort_column') ?? 'id';
        $pagination = true;

        $activityLogs = Activity::select('activity_log.id', 'activity_log.log_name', 'activity_log.event', 'activity_log.description', 'activity_log.causer_type', 'activity_log.causer_id', 'activity_log.subject_type', 'activity_log.created_at', 'users.id as user_id', 'users.name', 'users.email')
            ->join('users', 'users.id', '=', 'activity_log.causer_id')
            ->with('causer')
            ->when($params['search'] ?? false, function ($query) use ($params) {
                $query->where(function ($qry) use ($params) {
                    $qry->where('activity_log.event', 'like', '%' . $params['search'] . '%')
                        ->orWhere('activity_log.subject_type', 'like', '%' . $params['search'] . '%')
                        ->orWhere('users.name', 'like', '%' . $params['search'] . '%');
                });
            })
            ->when($params['event'] ?? false, function ($query) use ($params) {
                $query->where('activity_log.event', $params['event']);
            })
            ->when($params['subject_type'] ?? false, function ($query) use ($params) {
                $query->where('activity_log.subject_type', $params['subject_type']);
            })
            ->when($params['case_number_value'] ?? false, function ($query) use ($params) {
                $query->where('activity_log.subject_id', $params['case_number_value']);
            })
            ->when($params['activity_log_range'] ?? false, function ($query) use ($params) {
                $dates = explode(' - ', ($params['activity_log_range']));
                $query->whereBetween('activity_log.created_at', [$dates[0] . ' 00:00:00', $dates[1] . ' 23:59:59']);
            })
            ->when(isset($sortType, $sortColumn), function ($qry) use ($sortType, $sortColumn) {

                if (isset($sortColumn) && $sortColumn == 'causer_id') {
                    return $qry->orderBy('users.name', $sortType);
                } else {
                    return $qry->orderBy($sortColumn, $sortType);
                }
            })
            ->when($pagination, function ($qry) use ($perPage) {
                return $qry->paginate($perPage);
            }, function ($qry) {
                return $qry->get();
            });
        
        return view('admin.activity-log.ajax.activity-logs-data-table', ['activityLogs' => $activityLogs, 'sortType' => $sortType, 'sortColumn' => $sortColumn, 'perPage' => $perPage]);
    }

    public function export(Request $request, $id)
    {
        try {
            $path = 'export_active_log_'.time().'.xlsx';

            $param ['id'] = $id;
            
            return Excel::download(new ActivityLogExport($param), $path);

        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
