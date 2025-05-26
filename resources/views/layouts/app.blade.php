<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bulk SMS App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    {{-- App Navigation --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">SMS App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('send-sms') ? 'active' : '' }}" href="{{ url('/send-sms') }}">Send SMS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('bulk-sms') ? 'active' : '' }}" href="{{ url('/bulk-sms') }}">Bulk SMS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('campaigns') ? 'active' : '' }}" href="{{ route('campaigns.index') }}">Campaigns</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('opt-outs') ? 'active' : '' }}" href="{{ route('opt-outs.index') }}">Opt-Outs</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <div class="container">
        @yield('content')
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
