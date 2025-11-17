@extends('layouts.app')

@section('title', 'Manage Books - Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h1>Manage Books</h1>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Book
        </a>
    </div>
</div>

@if($books->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Reviews</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->genre ?? 'N/A' }}</td>
                        <td>{{ $book->reviews_count }}</td>
                        <td>
                            @if($book->average_rating > 0)
                                <span class="star-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= round($book->average_rating) ? '-fill' : '' }}"></i>
                                    @endfor
                                </span>
                                {{ number_format($book->average_rating, 1) }}
                            @else
                                No ratings
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Are you sure you want to delete this book?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $books->links() }}
    </div>
@else
    <div class="alert alert-info">
        <p>No books found.</p>
    </div>
@endif

<div class="mt-3">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection

