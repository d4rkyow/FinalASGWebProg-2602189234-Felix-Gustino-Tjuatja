@extends('layout.navbar')

@section('title', 'Home')
@section('activeHome', 'active')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="container">
        <div class="alert alert-info">
            <h3>@lang('messages.notifications')</h3>
            <ul class="list-unstyled mb-0">
                @forelse (Auth::user()->notifications as $notification)
                    <li>
                        {{ $notification->data['message'] }}
                        <a href="{{ route('notifications.destroy', $notification->id) }}" class="btn btn-danger btn-sm ms-2"
                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $notification->id }}').submit();">
                            <i class="icon-close"></i>
                        </a>

                        <form id="delete-form-{{ $notification->id }}"
                            action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                            style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </li>
                @empty
                    <li>@lang('messages.no_notifications')</li>
                @endforelse
            </ul>
        </div>

        <div class="row mt-4">
            <form method="GET" action="{{ route('user.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <input type="text" name="search" class="form-control" placeholder="@lang('messages.search_placeholder')" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="d-flex flex-wrap">
                            @foreach(['badminton', 'game', 'run', 'basketball', 'drawing'] as $hobby)
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" name="hobbies[]" value="{{ $hobby }}" id="{{ $hobby }}"
                                        {{ (is_array(request('hobbies')) && in_array($hobby, request('hobbies'))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $hobby }}">
                                        {{ ucfirst($hobby) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn btn-primary w-100">@lang('messages.search_filter')</button>
                    </div>
                </div>
            </form>

            @foreach ($dataUser->where('visible', true) as $user)
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
                                            <strong>@lang('messages.hobbies'):</strong> {{ implode(', ', $hobbies) }}
                                        </p>
                                    @endif
                                    <form method="POST" action="{{ route('friend-request.store') }}" class="mt-auto">
                                        @csrf
                                        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                                        <button type="submit" class="btn btn-link p-0 w-100 mt-5">
                                            <img src="{{ asset('images/like.png') }}" alt="@lang('messages.send_request')" style="width: 100px; height: 100px;">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
