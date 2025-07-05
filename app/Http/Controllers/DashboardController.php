<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\CareTask;
use App\Models\NursingNote;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    // DashboardController.php
    public function index()
    {
        $patientCount = Patient::count();

        $reminders = CareTask::with('patient')
            ->whereDate('scheduled_time', now()->toDateString())
            ->orderBy('scheduled_time')
            ->get();

        $notes = \App\Models\NursingNote::latest()->take(5)->get();

        return view('dashboard', compact('patientCount', 'reminders', 'notes'));
    }
}
