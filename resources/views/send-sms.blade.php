<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send SMS</title>

    <!-- Pull in Bootstrap via CDN for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4">Send an SMS</h1>

    <!-- Display a success message if one is in session -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form to send SMS -->
    <form action="{{ route('sms.send') }}" method="POST">
        @csrf

        <!-- Phone number input -->
        <div class="mb-3">
            <label for="recipient" class="form-label">Phone Number</label>
            <input type="text" name="recipient" id="recipient" class="form-control" placeholder="+1234567890" required>
        </div>

        <!-- Message textarea -->
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Send SMS</button>
    </form>
</div>

</body>
</html>