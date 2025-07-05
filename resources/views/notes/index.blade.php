{{-- @extends('layouts.nurse')

@section('content')
    <h2 class="text-2xl font-semibold text-yellow-900">[ Page Name ]</h2>
    <p class="mt-4 text-gray-700">This is the [ Page Name ] page.</p>
@endsection --}}
@extends('layouts.nurse')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-2xl font-semibold text-yellow-900 mb-4">Nursing Notes</h2>

    <!-- Add Note Button -->
    <div class="mb-6">
        <button onclick="openNoteModal()" class="bg-yellow-900 text-white px-4 py-2 rounded hover:bg-yellow-700">
            + Add Note
        </button>
    </div>

    <!-- Notes List -->
    <div id="notesList" class="space-y-4">
        @foreach ($notes as $note)
            <div class="bg-white p-4 rounded shadow relative">
                <p class="text-gray-800">{{ $note->note }}</p>
                <div class="text-sm text-gray-500 mt-2">{{ $note->created_at->diffForHumans() }}</div>
                <div class="absolute top-2 right-2 flex space-x-2">
                    <button onclick="editNote({{ $note->id }}, '{{ addslashes($note->note) }}')" class="text-blue-600 hover:underline">Edit</button>
                    <button onclick="deleteNote({{ $note->id }})" class="text-red-600 hover:underline">Delete</button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $notes->links() }}
    </div>
</div>

<!-- Note Modal -->
<div id="noteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-md p-6 rounded shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-yellow-900" id="noteModalTitle">Add Note</h3>
            <button onclick="closeNoteModal()" class="text-gray-600 hover:text-gray-800 text-xl">&times;</button>
        </div>
        <form id="noteForm">
            @csrf
            <input type="hidden" id="noteId">
            <textarea id="noteText" class="w-full border rounded px-3 py-2 mb-4" rows="5" placeholder="Enter your observation..."></textarea>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeNoteModal()" class="text-gray-600">Cancel</button>
                <button type="submit" class="bg-yellow-900 text-white px-4 py-2 rounded hover:bg-yellow-700">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openNoteModal() {
        document.getElementById('noteModalTitle').textContent = 'Add Note';
        document.getElementById('noteId').value = '';
        document.getElementById('noteText').value = '';
        document.getElementById('noteModal').classList.remove('hidden');
    }

    function closeNoteModal() {
        document.getElementById('noteModal').classList.add('hidden');
    }

    function editNote(id, text) {
        document.getElementById('noteModalTitle').textContent = 'Edit Note';
        document.getElementById('noteId').value = id;
        document.getElementById('noteText').value = text;
        document.getElementById('noteModal').classList.remove('hidden');
    }

    async function deleteNote(id) {
        if (!confirm('Are you sure you want to delete this note?')) return;

        const res = await fetch(`/notes/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        });

        const data = await res.json();
        if (data.success) location.reload();
        else alert('Failed to delete note.');
    }

    document.getElementById('noteForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const id = document.getElementById('noteId').value;
        const note = document.getElementById('noteText').value;

        const url = id ? `/notes/${id}` : '/notes';
        const method = id ? 'PUT' : 'POST';

        const res = await fetch(url, {
            method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ note })
        });

        const data = await res.json();
        if (data.success) {
            closeNoteModal();
            location.reload();
        } else {
            alert('Failed to save note.');
        }
    });
</script>
@endsection

