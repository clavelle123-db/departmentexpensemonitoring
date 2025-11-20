@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pending Remittances</h2>

    @if($pendingRemittances->isEmpty())
        <p>No pending remittances.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Treasurer</th>
                    <th>Event</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingRemittances as $r)
                <tr>
                    <td>{{ $r->treasurer->name ?? 'N/A' }}</td>
                    <td>{{ $r->event->name ?? 'N/A' }}</td>
                    <td>{{ $r->amount }}</td>
                    <td>{{ $r->remittance_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection
