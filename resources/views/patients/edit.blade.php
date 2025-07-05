@extends('layouts.nurse')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-yellow-900 mb-4">Edit Patient</h2>

    <form method="POST" action="{{ route('patients.update', $patient->id) }}">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label class="block font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $patient->name) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Age</label>
                <input type="number" name="age" value="{{ old('age', $patient->age) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Room Number</label>
                <input type="text" name="room_number" value="{{ old('room_number', $patient->room_number) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Gender</label>
                <select name="gender" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="male" {{ $patient->gender === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $patient->gender === 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6">
            <a href="{{ route('patients.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
            <button type="submit" class="bg-yellow-900 text-white px-4 py-2 rounded hover:bg-yellow-700">Update</button>
        </div>
    </form>
</div>
@endsection
