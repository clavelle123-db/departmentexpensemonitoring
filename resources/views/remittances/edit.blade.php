@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Expense</h2>
    <form action="{{ route('remittances.update', $remittance->remittance_id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Treasurer</label>
            <input type="hidden" name="treasurer_id" value="{{ Auth::user()->id }}">
            {{-- <select name="treasurer_id" class="form-control">
                @foreach($treasurers as $treasurer)
                    <option value="{{ $treasurer->treasurer_id }}">{{ $treasurer->treasurer_name }}</option>
                @endforeach
            </select> --}}
        </div>
        <div class="mb-3">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" value="{{ $remittance->amount }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Remittance Date</label>
            <input type="date" name="remittance_date" value="{{ $remittance->remittance_date }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Remarks</label>
            <input type="text" name="remarks" value="{{ $remittance->remarks }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('remittances.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
