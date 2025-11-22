@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mt-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white mb-5">Pending Remittances</h1>
    </div>

    <div class="overflow-x-auto mt-3">
       <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow">
    <thead>
        <tr class="bg-gray-100 dark:bg-gray-700 text-left">
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Event</th>
            <th class="px-4 py-2">Amount</th>

            <th class="px-4 py-2">Treasurer ID</th>
            <th class="px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pendingRemittances as $r)
            <tr class="border-t border-gray-200 dark:border-gray-700 {{ $r->is_remitted == 0 ? '' : 'bg-blue-100' }}">
                <td class="px-4 py-2">{{ $r->remittance_id }}</td>
                <td class="px-4 py-2">{{ $r->event->event_name }}</td>
                <td class="px-4 py-2">{{ $r->amount }}</td>
              
                <td class="px-4 py-2">{{ $r->treasurer_id }}</td>
                <td class="px-4 py-2">
                    @if($r->is_remitted == 1)
                        <span class="text-green font-semibold">Accepted</span>
                    @else
                        <form action="{{ route('remittances.acknowledge', $r->remittance_id) }}" method="POST">
                            @csrf
                            <button class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">
                                Acknowledge
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
@endsection
