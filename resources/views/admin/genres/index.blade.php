@extends('layouts.app')

@section('title', 'Manage Genres - Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h1>Manage Genres</h1>
        <a href="{{ route('admin.genres.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Genre
        </a>
    </div>
</div>

@if($genres->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Genre Name</th>
                    <th>Number of Books</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($genres as $genre)
                    <tr>
                        <td>{{ $genre->genre }}</td>
                        <td>{{ $genre->book_count }}</td>
                        <td>
                            <a href="{{ route('admin.genres.edit', urlencode($genre->genre)) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.genres.destroy', urlencode($genre->genre)) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Are you sure? This will remove the genre from all books!')">
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
        {{ $genres->links() }}
    </div>
@else
    <div class="alert alert-info">
        <p>No genres found.</p>
    </div>
@endif

<div class="mt-3">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection

