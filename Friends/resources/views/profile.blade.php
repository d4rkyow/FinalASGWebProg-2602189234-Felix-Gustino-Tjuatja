@extends('layout.navbar')

@section('title', 'Profile')
@section('activeProfile', 'active')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container">
        <div class="col-6 offset-3 mb-4 justify-content-center align-items-center align-content-center">
            <div class="card h-100 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-8">
                        <img src="{{ asset('storage/' . $user->profile_path) }}" alt="{{ $user->name }}'s profile"
                             class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Name : {{ $user->name }}</h5>
                            @if($user->hobbies)
                                @php
                                    $hobbies = json_decode($user->hobbies, true); // Decode JSON into array
                                @endphp
                                <p class="card-text">
                                    <strong>Hobbies:</strong> {{ implode(', ', $hobbies) }}
                                </p>
                            @endif
                            <p class="card-text">
                                <strong>Email:</strong> {{ $user->email }}
                            </p>
                            <p class="card-text">
                                <strong>Gender:</strong> {{ $user->gender }}
                            </p>
                            <p class="card-text">
                                <strong>Instagram:</strong> {{ $user->instagram_username }}
                            </p>
                            <p class="card-text">
                                <strong>Mobile Number:</strong> {{ $user->mobile_number }}
                            </p>

                            <a href="{{ route('settings.index') }}" class="btn btn-secondary mt-3">
                                Go to Settings
                            </a>

                        </div>
                    </div>
                    <a href="{{ route('avatar.index') }}" class="btn btn-primary mt-3">Buy Avatar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
