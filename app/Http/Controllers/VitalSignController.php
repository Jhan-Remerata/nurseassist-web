<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\VitalSign;


class VitalSignController extends Controller
{
    public function index()
{
    $patients = Patient::with('vitalSign')->paginate(12);
    return view('vitals.index', compact('patients'));
}

// public function update(Request $request, $id)
// {
    
//     $validated = $request->validate([
//         'pulse_rate' => 'nullable|integer',
//         'temperature' => 'nullable|numeric',
//         'blood_pressure' => 'nullable|string',
//         'respiratory_rate' => 'nullable|integer',
//     ]);

//     $vital = VitalSign::updateOrCreate(
//         ['patient_id' => $id],
//         $validated
//     );

//     return response()->json(['success' => true, 'vital' => $vital]);
    
// }
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'pulse_rate' => 'nullable|integer',
        'temperature' => 'nullable|numeric',
        'blood_pressure' => 'nullable|string',
        'respiratory_rate' => 'nullable|integer',
    ]);

    $updateData = $request->only([
        'pulse_rate',
        'temperature',
        'blood_pressure',
        'respiratory_rate'
    ]);

    $vital = VitalSign::updateOrCreate(
        ['patient_id' => $id],
        $updateData
    );

    return response()->json(['success' => true, 'vital' => $vital]);
}

}
