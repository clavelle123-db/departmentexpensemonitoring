@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <!-- Heading -->
    <h2 class="text-3xl font-bold text-gray-800">Sections Management</h2>

    <!-- Add Section Button -->
    <a href="{{ route('sections.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
        Add Section
    </a>
</div>

<table class="min-w-full bg-white dark:bg-gray-800 rounded shadow overflow-hidden">
    <thead class="bg-gray-100 dark:bg-gray-700 text-left">
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Section Name</th>
            <th class="px-4 py-2">Year Level</th>
            <th class="px-4 py-2"># of Students</th>
            <th class="px-4 py-2">Treasurers</th>
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
                <span class="inline-block bg-blue-500 text-white text-sm px-2 py-1 rounded">
                    Rona Jean Escala Umbao
                </span>
            </td>
            <td class="px-4 py-2 flex space-x-2">
                <a href="{{ route('sections.edit', $section->section_id) }}"
                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                   Edit
                </a>
                <form action="{{ route('sections.destroy', $section->section_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Are you sure?')"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
