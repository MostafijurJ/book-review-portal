@extends('layouts.app')

@section('title', $book->title . ' - Book Review Portal')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        @if($book->cover_image)
            <img src="{{ $book->cover_image }}" 
                 class="img-fluid rounded shadow-sm" 
                 alt="{{ $book->title }}"
                 style="max-height: 400px; width: 100%; object-fit: contain; background-color: #f8f9fa;"
                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'300\' height=\'400\'%3E%3Crect fill=\'%23dee2e6\' width=\'300\' height=\'400\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial\' font-size=\'18\' fill=\'%236c757d\'%3E{{ $book->title }}%3C/text%3E%3C/svg%3E'; this.style.backgroundColor='#dee2e6';">
        @else
            <div class="bg-secondary rounded d-flex align-items-center justify-content-center shadow-sm" style="height: 400px; min-height: 400px;">
                <div class="text-center text-white">
                    <i class="bi bi-book" style="font-size: 5rem;"></i>
                    <p class="mt-2 mb-0">{{ $book->title }}</p>
                </div>
            </div>
        @endif

        @auth
            <div class="mt-3">
                <form action="{{ route('bookshelves.store', $book) }}" method="POST">
                    @csrf
                    <select name="status" class="form-select mb-2" onchange="this.form.submit()">
                        <option value="">Add to Shelf</option>
                        <option value="want_to_read" {{ $userBookshelf && $userBookshelf->status == 'want_to_read' ? 'selected' : '' }}>
                            Want to Read
                        </option>
                        <option value="currently_reading" {{ $userBookshelf && $userBookshelf->status == 'currently_reading' ? 'selected' : '' }}>
                            Currently Reading
                        </option>
                        <option value="read" {{ $userBookshelf && $userBookshelf->status == 'read' ? 'selected' : '' }}>
                            Read
                        </option>
                    </select>
                </form>
                @if($userBookshelf)
                    <form action="{{ route('bookshelves.destroy', $userBookshelf) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Remove from Shelf</button>
                    </form>
                @endif
            </div>
        @endauth
    </div>

    <div class="col-md-9">
        <h1>{{ $book->title }}</h1>
        <h4 class="text-muted">by {{ $book->author }}</h4>

        @if($book->average_rating > 0)
            <div class="mb-3">
                <span class="star-rating fs-4">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= round($book->average_rating) ? '-fill' : '' }}"></i>
                    @endfor
                </span>
                <span class="ms-2">{{ number_format($book->average_rating, 2) }} ({{ $book->total_reviews }} reviews)</span>
            </div>
        @endif

        @if($book->genre)
            <p><strong>Genre:</strong> <a href="{{ route('books.genre', $book->genre) }}">{{ $book->genre }}</a></p>
        @endif

        @if($book->synopsis)
            <div class="mb-3">
                <h5>Synopsis</h5>
                <p>{{ $book->synopsis }}</p>
            </div>
        @endif

        @if($book->publication_date || $book->publisher || $book->page_count)
            <div class="mb-3">
                <h5>Details</h5>
                <ul class="list-unstyled">
                    @if($book->publication_date)
                        <li><strong>Published:</strong> {{ $book->publication_date->format('F Y') }}</li>
                    @endif
                    @if($book->publisher)
                        <li><strong>Publisher:</strong> {{ $book->publisher }}</li>
                    @endif
                    @if($book->page_count)
                        <li><strong>Pages:</strong> {{ $book->page_count }}</li>
                    @endif
                </ul>
            </div>
        @endif
    </div>
</div>

<!-- Write Review Section -->
@auth
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Write Your Review</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reviews.store', $book) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" class="btn-check" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : ($i == 5 ? 'checked' : '') }}>
                                    <label class="btn btn-outline-warning" for="rating{{ $i }}">
                                        <i class="bi bi-star-fill"></i> {{ $i }}
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="review_text" class="form-label">Your Review</label>
                            <textarea class="form-control @error('review_text') is-invalid @enderror" 
                                      id="review_text" name="review_text" rows="5" required>{{ old('review_text') }}</textarea>
                            @error('review_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info">
        <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Sign up</a> to write a review.
    </div>
@endauth

<!-- Reviews Section -->
<div class="row">
    <div class="col-12">
        <h3>Reviews</h3>
        @if($book->reviews->count() > 0)
            @foreach($book->reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-0">
                                    <a href="{{ route('profiles.show', $review->user) }}" class="text-decoration-none">
                                        {{ $review->user->username }}
                                    </a>
                                </h6>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                            <div>
                                <span class="star-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </span>
                            </div>
                        </div>
                        <p class="mb-0">{{ $review->review_text }}</p>
                        <div class="mt-2">
                            @auth
                                @if($review->user_id !== auth()->id())
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" data-bs-target="#reportModal{{ $review->id }}">
                                        <i class="bi bi-flag"></i> Report
                                    </button>
                                @else
                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Are you sure you want to delete this review?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Report Modal -->
                @auth
                    @if($review->user_id !== auth()->id())
                        <div class="modal fade" id="reportModal{{ $review->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('reviews.report', $review) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Report Review</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Reason</label>
                                                <select name="reason" class="form-select" required>
                                                    <option value="spam">Spam</option>
                                                    <option value="inappropriate">Inappropriate Content</option>
                                                    <option value="harassment">Harassment</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description (optional)</label>
                                                <textarea name="description" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Submit Report</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
            @endforeach
        @else
            <div class="alert alert-info">
                <p>No reviews yet. Be the first to review this book!</p>
            </div>
        @endif
    </div>
</div>
@endsection

