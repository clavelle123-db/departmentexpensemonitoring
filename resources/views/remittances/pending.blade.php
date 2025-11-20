<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Remittances</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Pending Remittances</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Event</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Treasurer</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pendingRemittances as $r)
                    <tr class="border-t border-gray-300 {{ $r->is_remitted == 0 ? '' : 'bg-blue-100' }}">
                        <td class="px-4 py-2">{{ $r->remittance_id }}</td>
                        <td class="px-4 py-2">{{ $r->event_name }}</td>
                        <td class="px-4 py-2">{{ $r->amount }}</td>
                        <td class="px-4 py-2">{{ $r->first_name }}</td>

                        <td class="px-4 py-2">
                            <form action="{{ route('remittances.acknowledge', $r->remittance_id) }}" method="POST">
                                @csrf
                                @if($r->is_remitted == 1)
                                    <span class="text-green-600 font-semibold">Accepted</span>
                                @else
                                    <button class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                                        Acknowledge
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</body>
</html>
