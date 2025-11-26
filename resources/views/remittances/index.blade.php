@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="mt-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white mb-5">Expenses</h1>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                    <a href="{{ route('remittances.create') }}" class="btn btn-primary mb-3">Add Expenses</a>
                </button>
                 <a href="https://www.iprogsms.com/free-sms/new"
   class="btn btn-success bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
    Sms
</a>
    </div>

    <div class="overflow-x-auto mt-3">
        <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-left">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Treasurer</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Remarks</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($remittances as $remittance)
                    <tr class="border-t border-gray-200 dark:border-gray-700 {{ $remittance->is_remitted ==0 ? '' : ' bg-blue-100' }}">
                        <td class="px-4 py-2">{{ $remittance->remittance_id }}</td>
                        <td class="px-4 py-2">{{ $remittance->treasurer->treasurer_name }}</td>
                        <td class="px-4 py-2">{{ $remittance->amount }}</td>
                        <td class="px-4 py-2">{{ $remittance->remittance_date }}</td>
                        <td class="px-4 py-2">{{ $remittance->remarks }}</td>
                        <td class="px-4 py-2 ">{{ $remittance->is_remitted ==0 ?'Pending':'Accepted' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('remittances.edit', $remittance->remittance_id) }}" class="text-blue-500 hover:text-blue-700">
                                <x-heroicon-s-pencil-square class="w-5 h-5" />
                            </a>
                            <form action="{{ route('remittances.destroy', $remittance->remittance_id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm text-red-600 hover:text-red-800" onclick="return confirm('Delete this remittance?')">
                                    <x-heroicon-s-trash class="w-5 h-5" />
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
