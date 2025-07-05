@extends('layouts.nurse')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-2xl font-semibold text-yellow-900 mb-6">Patient Reports</h2>

    @foreach($patients as $patient)
    <div class="border p-4 mb-4 rounded shadow">
        <h3 class="text-xl font-bold text-yellow-900">{{ $patient->name }}</h3>
        <p>Room: {{ $patient->room_number }}</p>
        <p>Age: {{ $patient->age }}</p>

        @if ($patient->vitalSign)
            <p>BP: {{ $patient->vitalSign->blood_pressure }}</p>
            <p>Temp: {{ $patient->vitalSign->temperature }}</p>
            <p>Pulse: {{ $patient->vitalSign->pulse_rate }}</p>
        @else
            <p class="text-gray-500">No vital signs recorded.</p>
        @endif

        @if ($patient->careTasks->count())
            <ul class="mt-2">
                @foreach ($patient->careTasks as $task)
                    <li class="text-sm text-gray-700">🕒 {{ $task->task_hour }} - {{ $task->task }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No care tasks assigned.</p>
        @endif

        <form action="{{ route('reports.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this patient\'s report data?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500">
                Delete Report Data
            </button>
        </form>

    </div>
@endforeach

<div class="mt-6">
    {{ $patients->links() }}
</div>


</div>
@endsection
