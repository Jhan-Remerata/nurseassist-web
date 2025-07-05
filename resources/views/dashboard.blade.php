@extends('layouts.nurse')

@section('content')
    <!-- Main Content -->
    <main class="flex-1 p-6 bg-gray-100 flex flex-col md:flex-row gap-6">
        <!-- Left Section: Patient Stats and Tasks -->
        <section class="w-full md:w-1/3 space-y-6">
            <!-- Patient Count -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-yellow-900">👥 Patients You're Handling</h3>
                <p class="text-3xl mt-2 font-bold text-gray-800">{{ $patientCount ?? 0 }}</p>
            </div>

            <!-- Shift Schedule -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-yellow-900">🗓️ Today’s Shift Schedule</h3>
                <ul class="mt-2 text-gray-700 list-disc list-inside space-y-1">
                    <li>7:00 AM - 3:00 PM: Ward A</li>
                    <li>3:00 PM - 11:00 PM: Ward B</li>
                </ul>
            </div>

            <!-- Task Reminders -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-yellow-900">⏰ Reminders</h3>
                <ul class="mt-2 text-gray-700 list-disc list-inside space-y-1">
                    @forelse ($reminders as $task)
                        <li>
                            {{ $task->task }} 
                            (Room {{ $task->patient->room_number ?? 'N/A' }}) 
                            at {{ \Carbon\Carbon::parse($task->scheduled_time)->format('g:i A') }}
                        </li>
                    @empty
                        <li>No tasks scheduled for today.</li>
                    @endforelse
                </ul>
            </div>
        </section>

        <!-- Right Section: Notes and Observations -->
        <section class="w-full md:w-2/3 space-y-6">
            <!-- Notes -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-yellow-900">📝 Recent Notes</h3>

                <ul class="mt-2 text-gray-700 list-disc list-inside space-y-1">
                    @forelse ($notes as $note)
                        <li>{{ $note->note ?? '[No content]' }}</li>
                    @empty
                        <li>No notes added yet.</li>
                    @endforelse
                </ul>


                <form action="{{ route('notes.store') }}" method="POST" class="mt-4 space-y-2">
                    @csrf
                    <textarea name="note" rows="4"
                        class="w-full p-3 border rounded border-gray-300 resize-none"
                        placeholder="Add a quick nursing note..."></textarea>
                    <button type="submit"
                        class="bg-yellow-900 text-white px-4 py-2 rounded hover:bg-yellow-700">Save Note</button>
                </form>

            </div>
        </section>
    </main>
    
    <script>
    document.querySelector('form[action="{{ route('notes.store') }}"]').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = this;
        const noteText = form.querySelector('textarea[name="note"]').value;

        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ note: noteText })
        });

        const data = await response.json();

        if (data.success) {
            // Optionally reload the page or append new note
            location.reload();
        } else {
            alert('Failed to save note.');
        }
    });
</script>

@endsection
