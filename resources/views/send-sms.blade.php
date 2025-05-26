@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Send an SMS</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('sms.send') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="recipient" class="form-label">Phone Number</label>
                <input type="text" name="recipient" id="recipient" class="form-control" placeholder="+1234567890" required>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Send SMS</button>
        </form>
    </div>
@endsection
