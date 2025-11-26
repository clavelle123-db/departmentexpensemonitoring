<!-- resources/views/sections/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Heading -->
    <h2 class="text-3xl font-bold mb-4 text-gray-800">Sections Management</h2>
    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
            <a href="{{ route('sections.create') }}" class="btn btn-primary">Add Section</a>
    </button>

</div>

<table class="min-w-full bg-white dark:bg-gray-800 rounded shadow">
    <thead class="table-dark">
        <tr class="bg-gray-100 dark:bg-gray-700">
            <th  class="px-4 py-2">ID</th>
            <th  class="px-4 py-2">Section Name</th>
            <th class="px-4 py-2">Year Level</th>
            <th class="px-4 py-2"># of Students</th>
            <th class="px-4 py-2">Treasurers</th>
            <th class="px-4 py-2">Events</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($sections as $section)
        <tr class="border-t border-gray-200 dark:border-gray-700">
            <td class="px-4 py-2">{{ $section->section_id }}</td>
            <td class="px-4 py-2">{{ $section->section_name }}</td>
            <td class="px-4 py-2">{{ $section->year_level }}</td>
            <td class="px-4 py-2">{{ $section->no_of_students }}</td>
            <td class="px-4 py-2">
                @foreach($section->treasurers as $treasurer)
                    <span class="badge bg-info">{{ $treasurer->user->first_name }}</span>
                @endforeach
            </td>
            <td class="px-4 py-2">
                @foreach($section->events as $event)
                    <span class="badge bg-success">{{ $event->event_name }}</span>
                @endforeach
            </td>
            <td class="px-4 py-2">
                <a href="{{ route('sections.edit', $section->section_id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('sections.destroy', $section->section_id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
