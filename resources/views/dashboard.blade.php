@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Message Dashboard</h2>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-5">
                <input type="text" name="phone" class="form-control" placeholder="Search by phone number" value="{{ request('phone') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">-- Filter by status --</option>
                    @foreach(['queued', 'sent', 'delivered', 'failed', 'undelivered'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
            </div>
        </div>
    </form>

    @if($contacts->isEmpty())
        <p>No messages found yet.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Contact</th>
                    <th>Phone</th>
                    <th>Messages</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                    <tr>
                        <td>{{ $contact->name ?? '—' }}</td>
                        <td>{{ $contact->phone_number }}</td>
                        <td>
                        @foreach($contact->messages as $message)
                            @php
                                $badgeClass = match($message->status) {
                                    'delivered' => 'success',
                                    'failed', 'undelivered' => 'danger',
                                    'queued', 'sent' => 'secondary',
                                    default => 'dark',
                                };
                            @endphp

                            <div class="mb-2">
                                <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($message->status) }}</span>
                                <div><strong>Text:</strong> {{ $message->body }}</div>
                                @if($message->campaign)
                                    <small class="text-muted">Campaign: {{ $message->campaign->name }}</small>
                                @endif
                            </div>
                        @endforeach

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
