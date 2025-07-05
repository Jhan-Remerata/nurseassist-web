<?php

namespace App\Http\Controllers;

use App\Models\CareTask;
use App\Models\Patient;
use Illuminate\Http\Request;

class CareTaskController extends Controller
{
    // Show task scheduler view with patients paginated
    public function index()
    {
        $patients = Patient::paginate(12);
        return view('tasks.index', compact('patients'));
    }

    // Return tasks of a patient in JSON format
    public function show(Patient $patient)
    {
        $tasks = $patient->careTasks()
                         ->select('id', 'patient_id', 'task', 'scheduled_time', 'shift')
                         ->orderBy('scheduled_time')
                         ->get();

        return response()->json(['tasks' => $tasks]);
    }
    
    

    // Store a new care task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'      => 'required|exists:patients,id',
            'task'            => 'required|string',
            'scheduled_time'  => 'required|date_format:H:i',
            'shift'           => 'required|in:morning,afternoon,night',
        ]);

        $task = CareTask::create($validated);

        return response()->json(['success' => true, 'task' => $task]);
    }

    // Update an existing care task
    public function update(Request $request, CareTask $careTask)
    {
        $validated = $request->validate([
            'task'            => 'required|string',
            'scheduled_time'  => 'required|date_format:H:i',
            'shift'           => 'required|in:morning,afternoon,night',
        ]);

        $careTask->update($validated);

        return response()->json(['success' => true, 'task' => $careTask]);
    }

    // Delete a care task
    public function destroy(CareTask $careTask)
    {
        $careTask->delete();

        return response()->json(['success' => true]);
    }
}
