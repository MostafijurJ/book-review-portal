@extends('layouts.app')

@section('title', 'Edit Book - Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1>Edit Book: {{ $book->title }}</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.books.update', $book) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $book->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Author *</label>
                        <input type="text" class="form-control @error('author') is-invalid @enderror" 
                               id="author" name="author" value="{{ old('author', $book->author) }}" required>
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="genre" class="form-label">Genre</label>
                        <input type="text" class="form-control @error('genre') is-invalid @enderror" 
                               id="genre" name="genre" value="{{ old('genre', $book->genre) }}" 
                               list="genres-list">
                        <datalist id="genres-list">
                            @foreach($genres as $genre)
                                <option value="{{ $genre }}">
                            @endforeach
                        </datalist>
                        @error('genre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="synopsis" class="form-label">Synopsis</label>
                        <textarea class="form-control @error('synopsis') is-invalid @enderror" 
                                  id="synopsis" name="synopsis" rows="5">{{ old('synopsis', $book->synopsis) }}</textarea>
                        @error('synopsis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input type="text" class="form-control @error('isbn') is-invalid @enderror" 
                                       id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}">
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cover_image" class="form-label">Cover Image URL</label>
                                <input type="text" class="form-control @error('cover_image') is-invalid @enderror" 
                                       id="cover_image" name="cover_image" value="{{ old('cover_image', $book->cover_image) }}"
                                       placeholder="https://example.com/image.jpg">
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Enter a full URL to an image (e.g., https://example.com/book-cover.jpg)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <small>Image Preview</small>
                                </div>
                                <div class="card-body text-center" style="min-height: 200px; background-color: #f8f9fa;">
                                    <img id="imagePreview" src="{{ old('cover_image', $book->cover_image) }}" alt="Preview" 
                                         style="max-width: 100%; max-height: 200px; {{ old('cover_image', $book->cover_image) ? '' : 'display: none;' }}"
                                         onerror="this.style.display='none'; document.getElementById('previewPlaceholder').style.display='block';">
                                    <div id="previewPlaceholder" style="display: {{ old('cover_image', $book->cover_image) ? 'none' : 'block' }}; padding: 20px;">
                                        <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                                        <p class="text-muted small mt-2 mb-0">Enter an image URL to see preview</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="publication_date" class="form-label">Publication Date</label>
                                <input type="date" class="form-control @error('publication_date') is-invalid @enderror" 
                                       id="publication_date" name="publication_date" 
                                       value="{{ old('publication_date', $book->publication_date ? $book->publication_date->format('Y-m-d') : '') }}">
                                @error('publication_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="publisher" class="form-label">Publisher</label>
                                <input type="text" class="form-control @error('publisher') is-invalid @enderror" 
                                       id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}">
                                @error('publisher')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="page_count" class="form-label">Page Count</label>
                                <input type="number" class="form-control @error('page_count') is-invalid @enderror" 
                                       id="page_count" name="page_count" value="{{ old('page_count', $book->page_count) }}" min="1">
                                @error('page_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Book</button>
                    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const coverImageInput = document.getElementById('cover_image');
        const imagePreview = document.getElementById('imagePreview');
        const previewPlaceholder = document.getElementById('previewPlaceholder');
        
        if (coverImageInput) {
            // Show preview on input
            coverImageInput.addEventListener('input', function() {
                const url = this.value.trim();
                
                if (url && (url.startsWith('http://') || url.startsWith('https://') || url.startsWith('//'))) {
                    // Ensure URL has protocol
                    let imageUrl = url;
                    if (url.startsWith('//')) {
                        imageUrl = 'https:' + url;
                    }
                    
                    imagePreview.src = imageUrl;
                    imagePreview.style.display = 'block';
                    previewPlaceholder.style.display = 'none';
                } else if (url === '') {
                    imagePreview.style.display = 'none';
                    previewPlaceholder.style.display = 'block';
                }
            });
            
            // Load preview if there's a value
            if (coverImageInput.value) {
                coverImageInput.dispatchEvent(new Event('input'));
            }
        }
    });
</script>
@endpush

