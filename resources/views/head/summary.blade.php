@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">Budget Summary</h1>
@if ($budget)
    <!-- Show assigned department's budget -->
@elseif (!empty($allBudgets) && $allBudgets->count())
    <div class="mt-6">
        <h2 class="text-2xl font-semibold mb-4">All Budgets</h2>
        <table class="w-full border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Department ID</th>
                    <th class="border px-4 py-2">Total Budget</th>
                    <th class="border px-4 py-2">Spent Amount</th>
                    <th class="border px-4 py-2">Remaining Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allBudgets as $b)
                    <tr>
                        <td class="border px-4 py-2">{{ $b->department_id }}</td>
                        <td class="border px-4 py-2">${{ number_format($b->total_amount, 2) }}</td>
                        <td class="border px-4 py-2">${{ number_format($b->spent_amount, 2) }}</td>
                        <td class="border px-4 py-2">${{ number_format($b->remaining_amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="mt-6 p-4 bg-red-100 text-center rounded-md">
        <p class="text-lg font-medium text-red-600">No budget data available.</p>
    </div>
@endif
    </div>
@endsection
