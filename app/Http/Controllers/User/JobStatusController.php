<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Imtigger\LaravelJobStatus\JobStatus;
use Settings;

class JobStatusController extends Controller
{
    public function index()
    {
        $data['routePrefix'] = auth()->user()->akses . '.jobstatus';
        $data['title'] = 'Buat Tagihan';
        $data['models'] = JobStatus::latest()->paginate(Settings('app_pagination'));
        return view('user.jobstatus_index', $data);
    }

    // public function create(Request $request)
    // {
    //     # code...
    // }

    public function show($id)
    {
        $job = JobStatus::findOrFail($id);
        $data = [
            'id' => $job->id,
            'progress_now' => $job->progress_now,
            'progress_max' => $job->progress_max,
            'progress_percentage' => $job->progress_percentage,
            'is_ended' => $job->is_ended,
        ];

        return response()->json($data, 200);
    }
}
