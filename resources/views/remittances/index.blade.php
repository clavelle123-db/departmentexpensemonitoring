@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="mt-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white mb-5">Remittances</h1>

        <a href="{{ route('remittances.create') }}"
           class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 mb-3 inline-block">
           Add Remittance
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
                    <th class="px-4 py-2">Treasurer</th>
                    <th class="px-4 py-2">Event</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Remarks</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($remittances as $remittance)
                    <tr class="border-t border-gray-200 dark:border-gray-700 {{ $remittance->is_remitted == 0 ? '' : ' bg-blue-100' }}">
                        <td class="px-4 py-2">{{ $remittance->remittance_id }}</td>
                        <td class="px-4 py-2">{{ $remittance->treasurer->user->first_name ?? '' }} {{ $remittance->treasurer->user->last_name ?? '' }}</td>
                        <td class="px-4 py-2">{{ $remittance->event->event_name ?? '' }}</td>
                        <td class="px-4 py-2">{{ $remittance->amount }}</td>
                        <td class="px-4 py-2">{{ $remittance->remittance_date }}</td>
                        <td class="px-4 py-2">{{ $remittance->remarks }}</td>
                        <td class="px-4 py-2">{{ $remittance->is_remitted == 0 ? 'Pending' : 'Accepted' }}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="{{ route('remittances.edit', $remittance->remittance_id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                               Edit
                            </a>
                            <form action="{{ route('remittances.destroy', $remittance->remittance_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Delete this remittance?')"
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
