@extends('layout.navbar')

@section('title', 'Message')
@section('activeMessage', 'active')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card chat-room shadow-sm">
                    <div class="card-body">
                        <div class="chat-messages" style="height: 400px; overflow-y: auto;">
                            @foreach ($messages as $msg)
                                <div class="d-flex mb-3 {{ $msg->sender_id === auth()->user()->id ? 'justify-content-end' : 'justify-content-start' }}">
                                    <div class="message-container">
                                        <div class="message p-3 pl-2 pr-2 rounded-3 {{ $msg->sender_id === auth()->user()->id ? 'bg-primary text-white' : 'bg-light' }}"
                                             style="max-width: 100%;">
                                            <p class="mb-0">{{ $msg->message }}</p>
                                        </div>
                                        <p class="text-muted {{ $msg->sender_id === auth()->user()->id ? 'text-end' : 'text-start' }} mt-1 mb-0"
                                           style="font-size: 0.75rem;">
                                            @if ($msg->created_at)
                                                {{ $msg->created_at->format('H:i') }}
                                            @else
                                                --
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('message.store') }}" class="mt-3">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="new_message" class="form-control" placeholder="Enter your message" required>
                        <input type="hidden" name="friend_id" value="{{ $friend->id }}">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
