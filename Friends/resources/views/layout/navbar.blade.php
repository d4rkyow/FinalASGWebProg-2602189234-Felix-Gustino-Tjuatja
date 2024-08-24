<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-info">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand">Casual Friend</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0 mr-0">
                    <li class="nav-item">
                        <a class="nav-link @yield('activeHome')" href="{{ route('user.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('activeRequest')" href="{{ route('friend-request.index') }}">Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('activeFriend')" href="{{ route('friend.index') }}">Friends</a>
                    </li>
                </ul>

                <div class="mx-auto">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Friends Connect" class="d-block" style="height: 40px;">
                </div>

                <!-- Language Switcher Dropdown -->
                <div class="dropdown me-3">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ strtoupper(app()->getLocale()) }} <!-- Displays the current language -->
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                        <li><a class="dropdown-item" href="{{ route('setLocale', 'en') }}">English</a></li>
                        <li><a class="dropdown-item" href="{{ route('setLocale', 'id') }}">Indonesian</a></li>
                    </ul>
                </div>

                @if (Auth::check())
                    <div class="d-flex align-items-center">
                        <a href="{{ route('profile') }}" class="d-flex align-items-center text-decoration-none">
                            <img src="{{ asset('storage/' . Auth::user()->profile_path) }}" alt="Profile Picture"
                                class="rounded-circle me-2" style="height: 40px; width: 40px; object-fit: cover;">
                            <span class="text-light me-3">Hi, {{ Auth::user()->name }}!</span>
                        </a>
                        <form method="POST" action="{{ url('/logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light">Logout</button>
                        </form>
                    </div>
                @else
                    <div class="d-flex">
                        <a href="{{ url('/login') }}" class="btn btn-outline-light me-2">Login</a>
                        <a href="{{ url('/register') }}" class="btn btn-primary">Register</a>
                    </div>
                @endif
            </div>
        </div>
    </nav>
    <main class="container mt-5">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
