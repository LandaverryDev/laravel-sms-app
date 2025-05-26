@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Campaign Manager</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Create Campaign Form --}}
    <form method="POST" action="{{ route('campaigns.store') }}" class="mb-4 row g-3">
        @csrf
        <div class="col-md-5">
            <input type="text" name="name" class="form-control" placeholder="Campaign Name" required>
        </div>
        <div class="col-md-5">
            <input type="text" name="description" class="form-control" placeholder="Optional Description">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Create</button>
        </div>
    </form>

    {{-- List of Campaigns --}}
    @if($campaigns->isEmpty())
        <p>No campaigns yet.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($campaigns as $campaign)
                    <tr>
                        <td>{{ $campaign->name }}</td>
                        <td>{{ $campaign->description ?? '—' }}</td>
                        <td>{{ $campaign->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
