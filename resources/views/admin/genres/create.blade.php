@extends('layouts.app')

@section('title', 'Add New Genre - Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1>Add New Genre</h1>
        <p class="text-muted">Note: Genres are automatically created when you add books. You can also create one here for reference.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.genres.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="genre" class="form-label">Genre Name *</label>
                        <input type="text" class="form-control @error('genre') is-invalid @enderror" 
                               id="genre" name="genre" value="{{ old('genre') }}" required>
                        @error('genre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Genre</button>
                    <a href="{{ route('admin.genres.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

