@extends('layouts.app')

@section('title', 'Browse Books - Book Review Portal')

@section('content')
<div class="row mb-4 fade-in">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="fw-bold mb-2">
                    <i class="bi bi-book-half text-primary me-2"></i>Browse Books
                </h1>
                <p class="text-muted mb-0">Discover your next great read</p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Home
            </a>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="row mb-4 fade-in">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('books.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0" 
                                       name="search" 
                                       placeholder="Search by title or author..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            @if($genres->count() > 0)
                                <select class="form-select form-select-lg" 
                                        onchange="if(this.value) window.location.href='{{ route('books.index') }}?genre='+this.value">
                                    <option value="">All Genres</option>
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                            {{ $genre }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    @if(request('search') || request('genre'))
                        <div class="mt-3">
                            <a href="{{ route('books.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Clear Filters
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Books Grid -->
@if($books->count() > 0)
    <div class="row g-4 fade-in">
        @foreach($books as $book)
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card book-card h-100 border-0">
                    <a href="{{ route('books.show', $book) }}" class="text-decoration-none text-dark">
                        <div class="position-relative">
                            @if($book->cover_image)
                                <img src="{{ $book->cover_image }}" 
                                     class="card-img-top" 
                                     alt="{{ $book->title }}" 
                                     style="height: 280px; object-fit: cover; background-color: #f8f9fa;"
                                     onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'280\'%3E%3Crect fill=\'%23dee2e6\' width=\'200\' height=\'280\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial\' font-size=\'14\' fill=\'%236c757d\'%3E{{ Str::limit($book->title, 20) }}%3C/text%3E%3C/svg%3E'; this.style.objectFit='contain';">
                            @else
                                <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" 
                                     style="height: 280px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="bi bi-book text-white" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                            @if($book->average_rating > 0)
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 shadow-sm">
                                    <i class="bi bi-star-fill"></i> {{ number_format($book->average_rating, 1) }}
                                </span>
                            @endif
                            @if($book->genre)
                                <span class="badge bg-primary position-absolute bottom-0 start-0 m-2 shadow-sm">
                                    {{ $book->genre }}
                                </span>
                            @endif
                        </div>
                        <div class="card-body p-3">
                            <h6 class="card-title fw-semibold mb-2" style="font-size: 0.95rem; line-height: 1.3; min-height: 2.6rem;">
                                {{ Str::limit($book->title, 40) }}
                            </h6>
                            <p class="card-text text-muted small mb-2">{{ Str::limit($book->author, 30) }}</p>
                            @if($book->average_rating > 0)
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="star-rating" style="font-size: 0.85rem;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= round($book->average_rating) ? '-fill' : '' }}"></i>
                                        @endfor
                                    </span>
                                    <small class="text-muted">({{ $book->total_reviews }})</small>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            <div class="card shadow-sm">
                <div class="card-body">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card shadow-sm fade-in">
        <div class="card-body text-center p-5">
            <i class="bi bi-book-x" style="font-size: 4rem; color: #9ca3af;"></i>
            <h4 class="mt-3 mb-2">No books found</h4>
            <p class="text-muted mb-4">Try adjusting your search criteria or browse by genre.</p>
            <a href="{{ route('books.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-clockwise"></i> View All Books
            </a>
        </div>
    </div>
@endif
@endsection

