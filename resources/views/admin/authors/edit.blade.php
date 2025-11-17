@extends('layouts.app')

@section('title', 'Edit Author - Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1>Edit Author: {{ $author }}</h1>
        <p class="text-muted">This will update the author name for all {{ $books->count() }} book(s) by this author.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.authors.update', urlencode($author)) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="author" class="form-label">Author Name *</label>
                        <input type="text" class="form-control @error('author') is-invalid @enderror" 
                               id="author" name="author" value="{{ old('author', $author) }}" required>
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Author</button>
                    <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Books by this Author</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($books as $book)
                        <li class="list-group-item">
                            <a href="{{ route('books.show', $book) }}">{{ $book->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

