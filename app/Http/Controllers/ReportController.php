<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\VitalSign;

class ReportController extends Controller
{
public function index()
{
    $patients = Patient::whereHas('vitalSign')
        ->orWhereHas('careTasks')
        ->with(['vitalSign', 'careTasks'])
        ->paginate(5);

    return view('reports.index', compact('patients'));
}

public function destroy(Patient $patient)
{
    // Delete all care tasks related to the patient
    $patient->careTasks()->delete();

    // Delete the vital sign if it exists
    if ($patient->vitalSign) {
        $patient->vitalSign()->delete();
    }

    return redirect()->route('reports.index')->with('success', 'Report data deleted successfully.');
}



}
