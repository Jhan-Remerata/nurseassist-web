<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class NursingNoteController extends Controller
// {
//     //
// }
use App\Models\NursingNote;
use Illuminate\Http\Request;

class NursingNoteController extends Controller
{
    public function index()
    {
        $notes = NursingNote::latest()->paginate(10);
        return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $request->validate(['note' => 'required|string']);
        $note = NursingNote::create([
            'note' => $request->note,
            'nurse_id' => auth()->id(),
        ]);
        return response()->json(['success' => true, 'note' => $note]);
    }

    public function update(Request $request, $id)
    {
        $note = NursingNote::findOrFail($id);
        $request->validate(['note' => 'required|string']);
        $note->update(['note' => $request->note]);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $note = NursingNote::findOrFail($id);
        $note->delete();
        return response()->json(['success' => true]);
    }
}

