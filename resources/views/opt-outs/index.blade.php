@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Opt-Out Management</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Add Form --}}
    <form method="POST" action="{{ route('opt-outs.store') }}" class="mb-4 row g-3">
        @csrf
        <div class="col-md-8">
            <input type="text" name="phone_number" class="form-control" placeholder="+1XXXXXXXXXX" required>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-danger w-100">Add Opt-Out</button>
        </div>
    </form>

    {{-- Opted-Out Numbers --}}
    @if($optOuts->isEmpty())
        <p>No numbers are currently opted out.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Phone Number</th>
                    <th>Opted Out At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($optOuts as $optOut)
                    <tr>
                        <td>{{ $optOut->phone_number }}</td>
                        <td>{{ $optOut->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <form method="POST" action="{{ route('opt-outs.destroy', $optOut->id) }}" onsubmit="return confirm('Remove this number?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
