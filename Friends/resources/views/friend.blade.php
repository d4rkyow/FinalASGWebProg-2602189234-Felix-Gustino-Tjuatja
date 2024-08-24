@extends('layout.navbar')

@section('title', 'Friend')
@section('activeFriend', 'active')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container">
        <div class="row">
            @foreach ($dataFriend as $user)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $user->profile_path) }}" alt="{{ $user->name }}'s profile"
                                    class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $user->name }}</h5>
                                    @if($user->hobbies)
                                        @php
                                            $hobbies = json_decode($user->hobbies, true); 
                                        @endphp
                                        <p class="card-text">
                                            <strong>Hobbies:</strong> {{ implode(', ', $hobbies) }}
                                        </p>
                                    @endif
                                    <div class="d-flex justify-content-between mt-5">
                                        <a href="{{ route('message.show', $user->id) }}" class="btn btn-primary w-75">Message</a>
                                        <form action="{{ route('friend.destroy', $user->id) }}" method="POST" class="w-25 ms-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <img src="{{ asset('images/dislike.png') }}" alt="Dislike" style="width: 100%; height: 100%;">
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
