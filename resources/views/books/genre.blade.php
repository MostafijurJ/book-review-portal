@extends('layouts.app')

@section('title', $genre . ' Books - Book Review Portal')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1>{{ $genre }} Books</h1>
        <p><a href="{{ route('books.index') }}">← Back to all books</a></p>
    </div>
</div>

@if($books->count() > 0)
    <div class="row">
        @foreach($books as $book)
            <div class="col-md-3 col-lg-2 mb-4">
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
                            @if($book->average_rating > 0)
                                <div class="d-flex align-items-center">
                                    <span class="star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= round($book->average_rating) ? '-fill' : '' }}"></i>
                                        @endfor
                                    </span>
                                    <small class="text-muted ms-2">{{ number_format($book->average_rating, 1) }}</small>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-12">
            {{ $books->links() }}
        </div>
    </div>
@else
    <div class="alert alert-info">
        <p>No books found in this genre.</p>
    </div>
@endif
@endsection

