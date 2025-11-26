@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800 dark:text-white">Submit Expense</h2>

    <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="expense_date" class="block mb-1 font-medium text-gray-700 dark:text-white">Expense Date</label>
            <input type="date" name="expense_date" id="expense_date" class="form-control w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="category" class="block mb-1 font-medium text-gray-700 dark:text-white">Category</label>
            <input type="text" name="category" id="category" class="form-control w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="amount" class="block mb-1 font-medium text-gray-700 dark:text-white">Amount</label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block mb-1 font-medium text-gray-700 dark:text-white">Description</label>
            <textarea name="description" id="description" class="form-control w-full p-2 border rounded" rows="3"></textarea>
        </div>

        <div class="mb-4">
            <label for="receipt" class="block mb-1 font-medium text-gray-700 dark:text-white">Upload Receipt (optional)</label>
            <input type="file" name="receipt" id="receipt" class="form-control w-full p-2 border rounded" accept=".jpg,.jpeg,.png,.pdf">
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                Save
            </button>
            <a href="{{ route('expenses.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
