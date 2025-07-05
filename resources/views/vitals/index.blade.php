
@extends('layouts.nurse')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-2xl font-semibold text-yellow-900 mb-6">Vital Signs</h2>

    <!-- Patient Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8" id="patientGrid">
        @foreach ($patients as $patient)
            <div onclick="selectPatient({{ $patient->id }})"
                class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition cursor-pointer group relative">
                <img src="{{ asset('images/' . ($patient->gender === 'male' ? 'nurse-male.png' : 'nurse.png')) }}"
                     alt="Patient Icon"
                     class="w-24 h-24 mx-auto rounded-full object-cover border border-gray-300 mb-3">

                <div class="text-center">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $patient->name }}</h3>
                    <p class="text-sm text-gray-600">Age: {{ $patient->age }}</p>
                    <p class="text-sm text-gray-600">Room: {{ $patient->room_number }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mb-8">
        {{ $patients->links() }}
    </div>
</div>

<!-- Vital Sign Modal -->
{{-- <div id="vitalModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-yellow-900">Vital Signs</h3>
            <button onclick="closeVitalModal()" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>

        <div class="flex flex-col md:flex-row gap-6 items-start">
            <!-- Patient Info -->
            <div id="patientProfile" class="flex-1 text-center">
                <!-- JS fills this -->
            </div>

            <!-- Vital Form -->
            <form id="vitalForm" class="flex-1 space-y-3">
                @csrf
                <input type="hidden" name="patient_id" id="patientId">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pulse Rate</label>
                    <input type="number" name="pulse_rate" id="pulse_rate" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Temperature (°C)</label>
                    <input type="number" step="0.1" name="temperature" id="temperature" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Blood Pressure</label>
                    <input type="text" name="blood_pressure" id="blood_pressure" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Respiratory Rate</label>
                    <input type="number" name="respiratory_rate" id="respiratory_rate" class="w-full border rounded px-3 py-2" />
                </div>
                <div class="flex justify-end gap-4 mt-4">
                    <button type="button" onclick="closeVitalModal()" class="text-gray-600 hover:text-gray-800">Cancel</button>
                    <button type="submit" class="bg-yellow-900 text-white px-4 py-2 rounded hover:bg-yellow-700">Save</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
<!-- Vital Sign Modal -->
<div id="vitalModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-yellow-900">Vital Signs</h3>
            <button onclick="closeVitalModal()" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>

        <div class="flex flex-col md:flex-row gap-6 items-start">
            <!-- Patient Info -->
            <div id="patientProfile" class="flex-1 text-center">
                <!-- Filled dynamically -->
            </div>

            <!-- Vital Info Display -->
            <div id="vitalDisplay" class="flex-1 space-y-2">
                <p><strong>Pulse Rate:</strong> <span id="vPulseRate">--</span></p>
                <p><strong>Temperature:</strong> <span id="vTemperature">--</span> °C</p>
                <p><strong>Blood Pressure:</strong> <span id="vBloodPressure">--</span></p>
                <p><strong>Respiratory Rate:</strong> <span id="vRespiratoryRate">--</span></p>
                <button onclick="enableEdit()" class="mt-4 bg-yellow-900 text-white px-4 py-2 rounded hover:bg-yellow-700">Edit</button>
            </div>

            <!-- Vital Edit Form (initially hidden) -->
            <form id="vitalForm" class="flex-1 space-y-3 hidden">
                @csrf
                @method('PUT')
                <input type="hidden" name="patient_id" id="patientId">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pulse Rate</label>
                    <input type="number" name="pulse_rate" id="pulse_rate" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Temperature (°C)</label>
                    <input type="number" step="0.1" name="temperature" id="temperature" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Blood Pressure</label>
                    <input type="text" name="blood_pressure" id="blood_pressure" class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Respiratory Rate</label>
                    <input type="number" name="respiratory_rate" id="respiratory_rate" class="w-full border rounded px-3 py-2" />
                </div>
                <div class="flex justify-end gap-4 mt-4">
                    <button type="button" onclick="cancelEdit()" class="text-gray-600 hover:text-gray-800">Cancel</button>
                    <button type="submit" class="bg-yellow-900 text-white px-4 py-2 rounded hover:bg-yellow-700">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- <script>
    const patients = @json($patients->keyBy('id'));

    function selectPatient(id) {
        const patient = patients[id];
        const v = patient.vital_sign || {};

        // Fill profile
        // document.getElementById('patientProfile').innerHTML = `
        //     <img src="/images/${patient.gender === 'male' ? 'nurse-male.png' : 'nurse-icon.png'}"
        //         class="w-24 h-24 mx-auto rounded-full border mb-3" />
        //     <h3 class="text-lg font-semibold text-gray-800">${patient.name}</h3>
        //     <p class="text-sm text-gray-600">Age: ${patient.age}</p>
        //     <p class="text-sm text-gray-600">Room: ${patient.room_number}</p>
        // `;
            document.getElementById('patientProfile').innerHTML = `
            <img src="/images/${patient.gender === 'male' ? 'nurse-male.png' : 'nurse-icon.png'}"
                class="w-24 h-24 mx-auto rounded-full border mb-3" />
            <h3 class="text-lg font-semibold text-gray-800">${patient.name}</h3>
            <p class="text-sm text-gray-600">Age: ${patient.age}</p>
            <p class="text-sm text-gray-600">Room: ${patient.room_number}</p>
        `;


        // Fill form
        document.getElementById('patientId').value = id;
        document.getElementById('pulse_rate').value = v.pulse_rate || '';
        document.getElementById('temperature').value = v.temperature || '';
        document.getElementById('blood_pressure').value = v.blood_pressure || '';
        document.getElementById('respiratory_rate').value = v.respiratory_rate || '';

        // Show modal
        document.getElementById('vitalModal').classList.remove('hidden');
    }

    function closeVitalModal() {
        document.getElementById('vitalModal').classList.add('hidden');
    }

    // document.getElementById('vitalForm').addEventListener('submit', async function (e) {
    //     e.preventDefault();

    //     const id = document.getElementById('patientId').value;
    //     const formData = new FormData(e.target);

    //     try {
    //         // const response = await fetch(`/vitals/${id}`, {
    //         const response = await fetch(`/vitals/${id}`, {
    //             method: 'PUT',
    //             headers: {
    //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    //                 'Accept': 'application/json'
    //             },
    //             body: formData
    //         });

    //         const data = await response.json();

    //         if (data.success) {
    //             alert('Vital signs updated!');
    //             closeVitalModal();
    //         } else {
    //             alert('Failed to update vital signs.');
    //         }
    //     } catch (err) {
    //         alert('Error occurred.');
    //         console.error(err);
    //     }
    // });
    document.getElementById('vitalForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const id = document.getElementById('patientId').value;
    const formData = new FormData(e.target);

    try {
        const response = await fetch(`/vitals/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();
        console.log('Response:', data);

        if (data.success) {
            alert('Vital signs updated!');
            closeVitalModal();
        } else {
            alert('Failed to update vital signs.');
        }
    } catch (err) {
        alert('Error occurred.');
        console.error(err);
    }
});

</script> --}}
<script>
    const patients = @json($patients->keyBy('id'));

    function selectPatient(id) {
        const patient = patients[id];
        const v = patient.vital_sign || {};

        // Fill profile
        document.getElementById('patientProfile').innerHTML = `
            <img src="/images/${patient.gender === 'male' ? 'nurse-male.png' : 'nurse-icon.png'}"
                class="w-24 h-24 mx-auto rounded-full border mb-3" />
            <h3 class="text-lg font-semibold text-gray-800">${patient.name}</h3>
            <p class="text-sm text-gray-600">Age: ${patient.age}</p>
            <p class="text-sm text-gray-600">Room: ${patient.room_number}</p>
        `;

        // Fill read-only display
        document.getElementById('vPulseRate').textContent = v.pulse_rate ?? '--';
        document.getElementById('vTemperature').textContent = v.temperature ?? '--';
        document.getElementById('vBloodPressure').textContent = v.blood_pressure ?? '--';
        document.getElementById('vRespiratoryRate').textContent = v.respiratory_rate ?? '--';

        // Fill form fields
        document.getElementById('patientId').value = id;
        document.getElementById('pulse_rate').value = v.pulse_rate || '';
        document.getElementById('temperature').value = v.temperature || '';
        document.getElementById('blood_pressure').value = v.blood_pressure || '';
        document.getElementById('respiratory_rate').value = v.respiratory_rate || '';

        // Reset modal state
        document.getElementById('vitalDisplay').classList.remove('hidden');
        document.getElementById('vitalForm').classList.add('hidden');
        document.getElementById('vitalModal').classList.remove('hidden');
    }

    function enableEdit() {
        document.getElementById('vitalDisplay').classList.add('hidden');
        document.getElementById('vitalForm').classList.remove('hidden');
    }

    function cancelEdit() {
        document.getElementById('vitalForm').classList.add('hidden');
        document.getElementById('vitalDisplay').classList.remove('hidden');
    }

    function closeVitalModal() {
        document.getElementById('vitalModal').classList.add('hidden');
    }

    // document.getElementById('vitalForm').addEventListener('submit', async function (e) {
    //     e.preventDefault();

    //     const id = document.getElementById('patientId').value;
    //     const formData = new FormData(this);

    //     try {
    //         const response = await fetch(`/vitals/${id}`, {
    //             method: 'POST',
    //             headers: {
    //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    //                 'Accept': 'application/json'
    //             },
    //             body: formData
    //         });

    //         const data = await response.json();

    //         if (data.success) {
    //             alert('Vital signs updated!');
    //             closeVitalModal();
    //         } else {
    //             alert('Failed to update vital signs.');
    //         }
    //     } catch (err) {
    //         alert('Error occurred.');
    //         console.error(err);
    //     }
    // });
    document.getElementById('vitalForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const id = document.getElementById('patientId').value;
    const formData = new FormData(this);

    try {
        const response = await fetch(`/vitals/${id}`, {
            method: 'POST', // Use POST if you kept the route that way
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            const v = data.vital;

            // 1. Update visible vital values
            document.getElementById('vPulseRate').textContent = v.pulse_rate ?? '--';
            document.getElementById('vTemperature').textContent = v.temperature ?? '--';
            document.getElementById('vBloodPressure').textContent = v.blood_pressure ?? '--';
            document.getElementById('vRespiratoryRate').textContent = v.respiratory_rate ?? '--';

            // 2. Update JS object so it reflects new data
            if (!patients[id].vital_sign) patients[id].vital_sign = {};
            patients[id].vital_sign = {
                pulse_rate: v.pulse_rate,
                temperature: v.temperature,
                blood_pressure: v.blood_pressure,
                respiratory_rate: v.respiratory_rate
            };

            // 3. Hide form, show display
            cancelEdit();

            alert('Vital signs updated!');
        } else {
            alert('Failed to update vital signs.');
        }
    } catch (err) {
        alert('Error occurred.');
        console.error(err);
    }
});

</script>

@endsection
