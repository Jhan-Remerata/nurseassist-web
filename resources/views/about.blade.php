@extends('layouts.nurse')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded shadow-lg">
        <h1 class="text-3xl font-bold text-yellow-900 mb-4">About NurseAssist Web</h1>

        <p class="text-gray-700 mb-4">
            NurseAssist Web is a lightweight, easy-to-use system designed to support nurses in managing patient care more efficiently. Built with the modern nurse in mind, the system provides essential tools to help streamline daily responsibilities while maintaining compassionate, high-quality care.
        </p>

        <h2 class="text-2xl font-semibold text-yellow-800 mt-6 mb-2">Our Features</h2>
        <ul class="list-disc list-inside text-gray-700 space-y-1">
            <li>📘 Patient Book – Quick access to patient info, updates, and profiles.</li>
            <li>🩺 Vital Signs – Record and monitor vital signs in real time.</li>
            <li>⏰ Care Task Scheduler – Schedule and track tasks by shift.</li>
            <li>📄 Reports – Generate comprehensive care summaries and task reports.</li>
            <li>📝 Nursing Notes – Document patient observations and progress.</li>
            <li>📊 Dashboard – View quick stats, reminders, and notes all in one place.</li>
        </ul>

        <h2 class="text-2xl font-semibold text-yellow-800 mt-6 mb-2">Our Mission</h2>
        <p class="text-gray-700 mb-4">
            To empower nurses by providing a reliable, minimal, and responsive platform that reduces paperwork and supports better decision-making at the point of care.
        </p>

        <h2 class="text-2xl font-semibold text-yellow-800 mt-6 mb-2">Built By</h2>
        <p class="text-gray-700 mb-2">
            This system was developed with care by a student aiming to bring modern tech solutions to nursing practice and improve the patient care experience.
        </p>
    </div>
</div>
@endsection
