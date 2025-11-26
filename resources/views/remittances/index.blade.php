@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="mt-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white mb-5">Expenses</h1>

        <a href="{{ route('expenses.create') }}"
           class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 mb-3 inline-block">
           Add Expense
        </a>

        <a href="https://www.iprogsms.com/free-sms/new"
           class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 ml-2">
           SMS
        </a>
    </div>

    <div class="overflow-x-auto mt-3">
        <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-left">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Department</th>
                    <th class="px-4 py-2">Category</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Receipt</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                    <tr class="border-t border-gray-200 dark:border-gray-700 {{ $expense->status == 'pending' ? '' : ' bg-blue-100' }}">
                        <td class="px-4 py-2">{{ $expense->id }}</td>
                        <td class="px-4 py-2">{{ $expense->user->first_name ?? '' }} {{ $expense->user->last_name ?? '' }}</td>
                        <td class="px-4 py-2">{{ $expense->department->name ?? '' }}</td>
                        <td class="px-4 py-2">{{ $expense->category }}</td>
                        <td class="px-4 py-2">{{ $expense->amount }}</td>
                        <td class="px-4 py-2">{{ $expense->expense_date }}</td>
                        <td class="px-4 py-2">{{ $expense->description }}</td>
                        <td class="px-4 py-2">
                            @if($expense->receipt)
                                <a href="{{ asset('storage/' . $expense->receipt) }}" target="_blank" class="text-blue-500 hover:underline">
                                    View
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ ucfirst($expense->status) }}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="{{ route('expenses.edit', $expense->id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                               Edit
                            </a>
                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Delete this expense?')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
