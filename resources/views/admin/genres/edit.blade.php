@extends('layouts.app')

@section('title', 'Edit Genre - Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1>Edit Genre: {{ $genre }}</h1>
        <p class="text-muted">This will update the genre for all {{ $books->count() }} book(s) with this genre.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.genres.update', urlencode($genre)) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="genre" class="form-label">Genre Name *</label>
                        <input type="text" class="form-control @error('genre') is-invalid @enderror" 
                               id="genre" name="genre" value="{{ old('genre', $genre) }}" required>
                        @error('genre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Genre</button>
                    <a href="{{ route('admin.genres.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Books with this Genre</h5>
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

