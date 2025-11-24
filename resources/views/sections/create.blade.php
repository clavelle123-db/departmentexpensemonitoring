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
                {{session(('success'))}}
            </div>
        @endif

        <!-- Validation Errors-->
        @if ($errors->any())
            <div class="alert alert-alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error )
                    <li> {{$error}}</li>
                    @endforeach
                {{session(('success'))}}
            </div>
        @endif
     </div>

     <div class="overflow-x-auto mt-3">
        <form action="{{ route('sections.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Section Name: </label>
                <input type="text" name="section_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Course and <br>Year Level (ex. BSIT-1):</label>
                <input type="text" name="year_level" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">No. of Students: </label>
                <input type="number" name="no_of_students" class="form-control" required>
            </div>
            <button class="btn btn-success bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Save</button>
          <a href="https://www.iprogsms.com/free-sms/new"
   class="btn btn-success bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
    Sms
</a>

            <button class="btn btn-danger bg-blue-red py-2 px-4 rounded-md hover:bg-indigo-700">
                <a href="{{ route('sections.index') }}" class="btn btn-danger" >Cancel</a>
            </button>

        </form>
     </div>

</div>


@endsection
