@extends('layouts.app')

@section('title', 'Home - Book Review Portal')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="display-4">Welcome to Book Review Portal</h1>
        <p class="lead">Discover, review, and organize your favorite books</p>
    </div>
</div>

<!-- Search Bar -->
<div class="row mb-5">
    <div class="col-md-8 mx-auto">
        <form action="{{ route('books.index') }}" method="GET">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" name="search" placeholder="Search for books by title or author..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Browse by Genre -->
@if($genres->count() > 0)
<div class="row mb-5">
    <div class="col-12">
        <h2 class="mb-3">Browse by Genre</h2>
        <div class="d-flex flex-wrap gap-2">
            @foreach($genres as $genre)
                <a href="{{ route('books.genre', $genre) }}" class="btn btn-outline-primary">
                    {{ $genre }}
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Featured Books -->
@if($featuredBooks->count() > 0)
<div class="row mb-5">
    <div class="col-12">
        <h2 class="mb-3">Top Rated Books</h2>
        <div class="row">
            @foreach($featuredBooks as $book)
                <div class="col-md-4 col-lg-2 mb-4">
                    <div class="card book-card h-100">
                        <a href="{{ route('books.show', $book) }}" class="text-decoration-none">
                            @if($book->cover_image)
                                <img src="{{ $book->cover_image }}" 
                                     class="card-img-top" 
                                     alt="{{ $book->title }}" 
                                     style="height: 200px; object-fit: cover; background-color: #f8f9fa;"
                                     onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'200\'%3E%3Crect fill=\'%23dee2e6\' width=\'200\' height=\'200\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial\' font-size=\'14\' fill=\'%236c757d\'%3E{{ Str::limit($book->title, 20) }}%3C/text%3E%3C/svg%3E'; this.style.objectFit='contain';">
                            @else
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-book text-white" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h6 class="card-title text-dark">{{ Str::limit($book->title, 30) }}</h6>
                                <p class="card-text text-muted small">{{ Str::limit($book->author, 25) }}</p>
                                <div class="d-flex align-items-center">
                                    <span class="star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= round($book->average_rating) ? '-fill' : '' }}"></i>
                                        @endfor
                                    </span>
                                    <small class="text-muted ms-2">{{ number_format($book->average_rating, 1) }}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Recent Books -->
@if($recentBooks->count() > 0)
<div class="row">
    <div class="col-12">
        <h2 class="mb-3">Recently Added Books</h2>
        <div class="row">
            @foreach($recentBooks as $book)
                <div class="col-md-4 col-lg-2 mb-4">
                    <div class="card book-card h-100">
                        <a href="{{ route('books.show', $book) }}" class="text-decoration-none">
                            @if($book->cover_image)
                                <img src="{{ $book->cover_image }}" 
                                     class="card-img-top" 
                                     alt="{{ $book->title }}" 
                                     style="height: 200px; object-fit: cover; background-color: #f8f9fa;"
                                     onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'200\'%3E%3Crect fill=\'%23dee2e6\' width=\'200\' height=\'200\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial\' font-size=\'14\' fill=\'%236c757d\'%3E{{ Str::limit($book->title, 20) }}%3C/text%3E%3C/svg%3E'; this.style.objectFit='contain';">
                            @else
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-book text-white" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h6 class="card-title text-dark">{{ Str::limit($book->title, 30) }}</h6>
                                <p class="card-text text-muted small">{{ Str::limit($book->author, 25) }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection

