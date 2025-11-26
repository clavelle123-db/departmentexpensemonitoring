@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800 dark:text-white">Submit Expense</h2>

    <form action="{{ route('remittances.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="event_name" class="block mb-1 font-medium text-gray-700 dark:text-white">Event Name</label>
            <input type="text" name="event_name" id="event_name" class="form-control w-full p-2 border rounded" placeholder="Enter event name" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700 dark:text-white">Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700 dark:text-white">Remittance Date</label>
            <input type="date" name="remittance_date" class="form-control w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700 dark:text-white">Remarks</label>
            <input type="text" name="remarks" class="form-control w-full p-2 border rounded">
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                Save
            </button>
            <a href="{{ route('remittances.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
