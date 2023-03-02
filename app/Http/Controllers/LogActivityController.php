<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Settings;
use Spatie\Activitylog\Models\Activity;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
        $data['models'] = Activity::latest();

        if ($request->filled('q')) {
            $userID = User::where('name', 'LIKE', '%' . $request->q . '%')->pluck('id');
            $data['models'] = $data['models']->whereIn('causer_id', $userID);
        }
        $data['models'] = $data['models']->paginate(Settings('app_pagination', '20'));

        $data['title'] = 'Aktivitas User';
        return view('operator.logactivity_index', $data);
    }

    public function deleteLog(Request $request)
    {
        $berhasilDihapus = 0;
        $message = 'Data berhasil dihapus';

        for ($i = 0; $i < count($request->activity_id); $i++) {

            $activity = Activity::where('id', $request->activity_id[$i])->first();
            if ($activity != null) {
                $activity->delete();
                $berhasilDihapus += 1;
            }
        }
        $message  = $message . ' : ' . $berhasilDihapus;

        return response()->json([
            'message' => $message,
        ], 200);
    }
}
