<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::latest()
            ->where('activity', '!=', 'GET users/activity-logs')
            ->get();

        return view('activity_logs.index', compact('logs'));
    }

    // Tambahkan method-method lain sesuai kebutuhan di sini
}
