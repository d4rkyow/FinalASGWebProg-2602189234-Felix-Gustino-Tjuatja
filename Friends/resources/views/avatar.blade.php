@extends('layout.navbar')

@section('title', 'Buy Avatar')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <h1 class="mb-4">Buy Avatar</h1>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                @foreach ($avatars as $avatar)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 text-center">
                            <img src="{{ asset('storage/' . $avatar['path']) }}" alt="Avatar" class="card-img-top"
                                    style="height: 200px; width:auto; object-fit: contain;">

                            <div class="card-body">
                                <h5 class="card-title">Price: {{ $avatar['price'] }} coins</h5>
                                <form action="{{ route('avatar.buy') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="price" value="{{ $avatar['price'] }}">
                                    <input type="hidden" name="path" value="{{ $avatar['path'] }}">
                                    <button type="submit" class="btn btn-primary" {{ Auth::user()->coins < $avatar['price'] ? 'disabled' : '' }}>
                                        Buy Avatar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{--  <!-- Bagian Koin dan Top Up di Sebelah Kanan -->  --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Your Coins</h5>
                    <p class="card-text">{{ Auth::user()->coins }} coins</p>
                    <form action="{{ route('topup.coins') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus"></i> Top Up 100 Coins
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
