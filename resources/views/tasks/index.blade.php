@extends('layouts.nurse')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-2xl font-semibold text-yellow-900 mb-6">Care Task Scheduler</h2>

    <!-- Patient Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
        @foreach ($patients as $patient)
            <div onclick="selectPatient({{ $patient->id }}, '{{ $patient->name }}', '{{ $patient->room_number }}', '{{ $patient->gender }}')"
                class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition cursor-pointer group">
                <img src="{{ asset('images/' . ($patient->gender === 'male' ? 'nurse-male.png' : 'nurse-icon.png')) }}"
                     class="w-24 h-24 mx-auto rounded-full border mb-3" />
                <div class="text-center">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $patient->name }}</h3>
                    <p class="text-sm text-gray-600">Room: {{ $patient->room_number }}</p>
                    <p class="text-sm text-gray-600">Age: {{ $patient->age }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mb-8">
        {{ $patients->links() }}
    </div>
</div>

<!-- Assign Task Modal -->
<div id="taskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-xl p-6 rounded-lg shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-yellow-900">Assign Task</h3>
            <button onclick="closeTaskModal()" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>

        <div class="text-center mb-4" id="selectedPatientInfo"></div>

        <form id="taskForm" class="space-y-4">
            @csrf
            <input type="hidden" name="patient_id" id="task_patient_id" />
            <input type="hidden" name="task_id" id="task_id" />
            <input type="hidden" name="shift" id="shift" />

            <div>
                <label class="block text-sm font-medium text-gray-700">Scheduled Time</label>
                <select name="scheduled_time" id="scheduled_time" class="w-full border rounded px-3 py-2">
                    <option value="">Select Hour</option>
                    @for ($h = 0; $h < 24; $h++)
                        <option value="{{ sprintf('%02d:00', $h) }}">{{ sprintf('%02d:00', $h) }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Task</label>
                <textarea name="task" id="task" rows="3" class="w-full border rounded px-3 py-2" placeholder="e.g., Check IV drip, Administer meds..."></textarea>
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeTaskModal()" class="text-gray-600 hover:text-gray-800">Cancel</button>
                <button type="submit" class="bg-yellow-900 text-white px-4 py-2 rounded hover:bg-yellow-700">Save Task</button>
            </div>
        </form>
    </div>
</div>

<!-- View Task Modal -->
<div id="viewTaskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-yellow-900">Scheduled Tasks</h3>
            <div class="space-x-2">
                <button onclick="openAddTaskModal()" class="bg-yellow-800 text-white px-3 py-1 rounded hover:bg-yellow-700 text-sm">Add Task</button>
                <button onclick="closeViewTaskModal()" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
            </div>
        </div>
        <div id="taskList" class="space-y-4 max-h-[300px] overflow-y-auto"></div>
    </div>
</div>

<script>
    let selectedPatientId = null;

    async function selectPatient(id, name, room, gender) {
        selectedPatientId = id;

        document.getElementById('selectedPatientInfo').innerHTML = `
            <img src="/images/${gender === 'male' ? 'nurse-male.png' : 'nurse-icon.png'}"
                class="w-20 h-20 mx-auto rounded-full border mb-2" />
            <h3 class="text-lg font-bold text-gray-800">${name}</h3>
            <p class="text-sm text-gray-600">Room: ${room}</p>
        `;

        document.getElementById('task_patient_id').value = id;
        document.getElementById('task').value = '';
        document.getElementById('scheduled_time').value = '';
        document.getElementById('task_id').value = '';

        try {
            const res = await fetch(`/care-tasks/${id}`);
            const data = await res.json();
            showTasks(data.tasks);
        } catch (err) {
            alert('Error loading tasks');
            console.error(err);
        }
    }

    function showTasks(tasks) {
        const list = document.getElementById('taskList');
        list.innerHTML = '';

        if (!tasks || tasks.length === 0) {
            list.innerHTML = '<p class="text-gray-600">No tasks scheduled yet.</p>';
        } else {
            tasks.forEach(task => {
                list.innerHTML += `
                    <div class="border rounded p-3 bg-gray-50 mb-2">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-yellow-900">${task.scheduled_time}</p>
                                <p class="text-gray-700">${task.task}</p>
                            </div>
                            <button onclick='editTask(${JSON.stringify(task)})'
                                class="text-blue-600 hover:underline text-sm">Edit</button>
                        </div>
                    </div>
                `;
            });
        }

        // Add Task Button
        // list.innerHTML += `
        //     <div class="mt-4 text-right">
        //         <button onclick="openAddTaskModal()"
        //             class="bg-yellow-800 text-white px-4 py-2 rounded hover:bg-yellow-700 text-sm">
        //             + Add Task
        //         </button>
        //     </div>
        // `;

        document.getElementById('viewTaskModal').classList.remove('hidden');
    }

    function openAddTaskModal() {
        closeViewTaskModal();

        document.getElementById('task_id').value = '';
        document.getElementById('task').value = '';
        document.getElementById('scheduled_time').value = '';
        document.getElementById('task_patient_id').value = selectedPatientId;

        document.getElementById('taskModal').classList.remove('hidden');
    }

    function editTask(task) {
        closeViewTaskModal();
        document.getElementById('taskModal').classList.remove('hidden');

        document.getElementById('task_patient_id').value = task.patient_id;
        document.getElementById('scheduled_time').value = task.scheduled_time;
        document.getElementById('task').value = task.task;
        document.getElementById('task_id').value = task.id;
    }

    function closeViewTaskModal() {
        document.getElementById('viewTaskModal').classList.add('hidden');
    }

    function closeTaskModal() {
        document.getElementById('taskModal').classList.add('hidden');
    }

    document.getElementById('taskForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        const hour = parseInt(document.getElementById('scheduled_time').value.split(':')[0]);
        let shift = '';
        if (hour >= 6 && hour < 14) shift = 'morning';
        else if (hour >= 14 && hour < 22) shift = 'afternoon';
        else shift = 'night';

        formData.set('shift', shift);

        const taskId = document.getElementById('task_id').value;
        const url = taskId ? `/care-tasks/${taskId}` : `/care-tasks`;
        const method = 'POST';

        if (taskId) {
            formData.append('_method', 'PUT');
        }

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                alert('Task saved!');
                closeTaskModal();

                const id = document.getElementById('task_patient_id').value;
                const res = await fetch(`/care-tasks/${id}`);
                const data = await res.json();
                showTasks(data.tasks);
            } else {
                alert('Failed to save task');
            }
        } catch (error) {
            alert('Error submitting task');
            console.error(error);
        }
    });
</script>

@endsection
