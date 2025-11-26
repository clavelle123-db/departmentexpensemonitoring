@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-6">
        <h2 class="text-2xl font-semibold text-gray-800">Submit Expense</h2>

        <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf


            <!-- Expense Date -->
            <div class="mb-4">
                <label for="expense_date" class="block text-sm font-medium text-gray-700">Expense Date</label>
                <input type="date" name="expense_date" id="expense_date"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm"
                    value="{{ old('expense_date') }}">
                @error('expense_date')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                <input type="text" name="category" id="category"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" value="{{ old('category') }}">
                @error('category')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Amount -->
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" name="amount" id="amount"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" step="0.01"
                    value="{{ old('amount') }}">
                @error('amount')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Receipt Upload -->
            <div class="mb-4">
                <label for="receipt" class="block text-sm font-medium text-gray-700">Upload Receipt</label>
                <input type="file" name="receipt" id="receipt"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                @error('receipt')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Submit
                    Expense</button>
            </div>
        </form>
    </div>
@endsection
