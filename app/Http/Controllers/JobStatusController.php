<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Imtigger\LaravelJobStatus\JobStatus;
use Settings;

class JobStatusController extends Controller
{
    public function index()
    {
        $data['routePrefix'] = 'jobstatus';
        $data['title'] = 'Buat Tagihan';
        $data['models'] = JobStatus::latest()->paginate(Settings('app_pagination'));
        return view('operator.jobstatus_index', $data);
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
