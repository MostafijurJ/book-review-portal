@extends('layouts.app')

@section('title', $user->username . ' - Profile - Book Review Portal')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
                <h3>{{ $user->username }}</h3>
                @if($user->bio)
                    <p class="text-muted">{{ $user->bio }}</p>
                @endif
                @if(auth()->check() && auth()->id() === $user->id)
                    <a href="{{ route('profiles.edit') }}" class="btn btn-primary">Edit Profile</a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <h2>Reviews ({{ $user->reviews->count() }})</h2>
        @if($user->reviews->count() > 0)
            @foreach($user->reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>
                            <a href="{{ route('books.show', $review->book) }}">{{ $review->book->title }}</a>
                            <span class="text-muted">by {{ $review->book->author }}</span>
                        </h5>
                        <div class="mb-2">
                            <span class="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                @endfor
                            </span>
                            <small class="text-muted ms-2">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        <p>{{ $review->review_text }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-muted">No reviews yet.</p>
        @endif

        <h2 class="mt-4">Bookshelves</h2>
        @php
            $statusLabels = [
                'want_to_read' => 'Want to Read',
                'currently_reading' => 'Currently Reading',
                'read' => 'Read',
            ];
        @endphp

        @foreach(['want_to_read', 'currently_reading', 'read'] as $status)
            <h4>{{ $statusLabels[$status] }} ({{ $bookshelves->get($status, collect())->count() }})</h4>
            @if($bookshelves->has($status) && $bookshelves->get($status)->count() > 0)
                <div class="row mb-3">
                    @foreach($bookshelves->get($status)->take(6) as $bookshelf)
                        <div class="col-md-2 mb-2">
                            <a href="{{ route('books.show', $bookshelf->book) }}" class="text-decoration-none">
                                @if($bookshelf->book->cover_image)
                                    <img src="{{ $bookshelf->book->cover_image }}" class="img-fluid rounded" alt="{{ $bookshelf->book->title }}">
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height: 100px;">
                                        <i class="bi bi-book text-white"></i>
                                    </div>
                                @endif
                                <small class="d-block text-dark mt-1">{{ Str::limit($bookshelf->book->title, 20) }}</small>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No books in this shelf.</p>
            @endif
        @endforeach
    </div>
</div>
@endsection

