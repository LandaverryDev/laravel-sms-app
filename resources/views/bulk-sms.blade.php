@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Send Bulk SMS</h2>

    {{-- Flash message if it exists --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Bulk SMS form --}}
    <form method="POST" action="{{ route('bulk-sms.send') }}" enctype="multipart/form-data">
        @csrf

        {{-- Option 1: manual input --}}
        <div class="mb-3">
            <label for="numbers" class="form-label">Phone Numbers (comma-separated)</label>
            <input type="text" class="form-control" name="numbers" id="numbers"
                   placeholder="+14359994486,+14359994487">
        </div>

        {{-- Option 2: CSV upload --}}
        <div class="mb-3">
            <label for="csv_file" class="form-label">Or Upload CSV</label>
            <input type="file" class="form-control" name="csv_file" id="csv_file" accept=".csv">
        </div>

        {{-- Message input --}}
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" name="message" id="message"
                      rows="4" placeholder="Type your message..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send Bulk SMS</button>
    </form>
@endsection