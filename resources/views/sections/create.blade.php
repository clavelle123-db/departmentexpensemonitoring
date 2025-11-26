<!-- resources/views/sections/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
     <div class="mt-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white mb-5">Add Section</h1>
     </div>
     <div class="mt-3">
        <!-- Success message-->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Validation Errors-->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error )
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
     </div>

     <div class="overflow-x-auto mt-3">
        <form action="{{ route('sections.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Section Name: </label>
                <input type="text" name="section_name" class="form-control" value="{{ old('section_name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Course and <br>Year Level (ex. BSIT-1):</label>
                <input type="text" name="year_level" class="form-control" value="{{ old('year_level') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">No. of Students: </label>
                <input type="number" name="no_of_students" class="form-control" value="{{ old('no_of_students') }}" required>
            </div>

          <!-- Treasurer dropdown -->
<div class="mb-3">
    <label class="form-label">Assign Treasurer:</label>
    <select name="treasurer_id" class="form-control" required>
        <option value="">-- Select Treasurer --</option>
        @foreach($treasurers as $treasurer)
            <option value="{{ $treasurer->id }}" {{ old('treasurer_id') == $treasurer->id ? 'selected' : '' }}>
                {{ $treasurer->name ?? $treasurer->first_name.' '.$treasurer->middle_name.' '.$treasurer->last_name }}
            </option>
        @endforeach
    </select>
</div>


            <button class="btn btn-success bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Save</button>

            <a href="{{ route('sections.index') }}" class="btn btn-danger bg-red-600 py-2 px-4 rounded-md hover:bg-red-700">Cancel</a>
        </form>
     </div>
</div>
@endsection
