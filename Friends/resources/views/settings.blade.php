@extends('layout.navbar')

@section('title', 'Settings')
@section('activeSettings', 'active')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container">
        <div class="col-6 offset-3 mb-4 justify-content-center align-items-center align-content-center">
            <div class="card h-100 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-12">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Settings</h5>
                            <p><strong>Coins:</strong> {{ $user->coins }}</p>

                            <!-- Button to disappear from home list -->
                            <form action="{{ route('settings.disappear') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" {{ $user->coins < 50 ? 'disabled' : '' }}>
                                    Disappear from Home List (50 Coins)
                                </button>
                            </form>

                            <!-- Button to reappear in the home list -->
                            <form action="{{ route('settings.reappear') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success" {{ $user->coins < 5 ? 'disabled' : '' }}>
                                    Reappear in Home List (5 Coins)
                                </button>
                            </form>

                            <!-- Button to go to profile -->
                            <a href="{{ route('profile') }}" class="btn btn-primary mt-3">
                                Go to Profile
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
