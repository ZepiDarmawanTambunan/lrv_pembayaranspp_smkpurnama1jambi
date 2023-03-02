<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;

class LogVisitorController extends Controller
{
    public function index(Request $request)
    {
        $data['models'] = DB::table('shetabit_visits')->latest();   // models
        $data['userActive'] = visitor()->onlineVisitors(User::class); // user active

        $userId = $data['models']->clone()->groupBy('visitor_id')->pluck('visitor_id'); // userId
        $data['user'] = User::whereIn('id', $userId)->get(); // user data

        if ($request->filled('q')) {
            $userID = User::where('name', 'LIKE', '%' . $request->q . '%')->pluck('id');
            $data['models'] = $data['models']->whereIn('visitor_id', $userID);
        }

        $data['models'] = $data['models']->paginate(Settings('app_pagination', '20')); //models paginate
        $data['title'] = 'Monitoring Traffic URL'; //title page

        return view('operator.logvisitor_index', $data);
    }

    public function deleteLog(Request $request)
    {
        $berhasilDihapus = 0;
        $message = 'Data berhasil dihapus';

        for ($i = 0; $i < count($request->visitor_id); $i++) {

            $logVisitor = DB::table('shetabit_visits')->where('id', $request->visitor_id[$i]);
            if ($logVisitor != null) {
                $logVisitor->delete();
                $berhasilDihapus += 1;
            }
        }
        $message  = $message . ' : ' . $berhasilDihapus;

        return response()->json([
            'message' => $message,
        ], 200);
    }
}
