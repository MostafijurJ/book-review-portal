@extends('layouts.app')

@section('title', 'Manage Authors - Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1>Manage Authors</h1>
    </div>
</div>

@if($authors->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Author Name</th>
                    <th>Number of Books</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($authors as $author)
                    <tr>
                        <td>{{ $author->author }}</td>
                        <td>{{ $author->book_count }}</td>
                        <td>
                            <a href="{{ route('admin.authors.edit', urlencode($author->author)) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.authors.destroy', urlencode($author->author)) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Are you sure? This will delete all books by this author!')">
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
        {{ $authors->links() }}
    </div>
@else
    <div class="alert alert-info">
        <p>No authors found.</p>
    </div>
@endif

<div class="mt-3">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection

