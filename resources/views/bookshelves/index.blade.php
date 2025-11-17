@extends('layouts.app')

@section('title', 'My Bookshelves - Book Review Portal')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1>My Bookshelves</h1>
    </div>
</div>

@php
    $statusLabels = [
        'want_to_read' => 'Want to Read',
        'currently_reading' => 'Currently Reading',
        'read' => 'Read',
    ];
@endphp

@foreach(['want_to_read', 'currently_reading', 'read'] as $status)
    <div class="row mb-5">
        <div class="col-12">
            <h3>{{ $statusLabels[$status] }} ({{ $bookshelves->get($status, collect())->count() }})</h3>
            @if($bookshelves->has($status) && $bookshelves->get($status)->count() > 0)
                <div class="row">
                    @foreach($bookshelves->get($status) as $bookshelf)
                        <div class="col-md-3 col-lg-2 mb-4">
                            <div class="card book-card h-100">
                                <a href="{{ route('books.show', $bookshelf->book) }}" class="text-decoration-none">
                                    @if($bookshelf->book->cover_image)
                                        <img src="{{ $bookshelf->book->cover_image }}" class="card-img-top" alt="{{ $bookshelf->book->title }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="bi bi-book text-white" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title text-dark">{{ Str::limit($bookshelf->book->title, 30) }}</h6>
                                        <p class="card-text text-muted small">{{ Str::limit($bookshelf->book->author, 25) }}</p>
                                    </div>
                                </a>
                                <div class="card-footer">
                                    <form action="{{ route('bookshelves.destroy', $bookshelf) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100" 
                                                onclick="return confirm('Remove from shelf?')">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No books in this shelf yet.</p>
            @endif
        </div>
    </div>
@endforeach
@endsection

