<h1>Pending Remittances</h1>

@foreach($pendingRemittances as $p)
    <p>{{ $p->treasurer_name }} - {{ $p->event_name }} - {{ $p->amount }}</p>
@endforeach
