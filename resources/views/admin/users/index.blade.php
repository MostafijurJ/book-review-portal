@extends('layouts.app')

@section('title', 'Manage Users - Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1>Manage Users</h1>
    </div>
</div>

@if($users->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Reviews</th>
                    <th>Bookshelves</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->reviews_count }}</td>
                        <td>{{ $user->bookshelves_count }}</td>
                        <td>
                            <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'warning' : 'danger') }}">
                                {{ ucfirst($user->status ?? 'active') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            @if($user->status !== 'suspended')
                                <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning" 
                                            onclick="return confirm('Suspend this user?')">
                                        <i class="bi bi-pause-circle"></i> Suspend
                                    </button>
                                </form>
                            @endif
                            @if($user->status !== 'banned')
                                <form action="{{ route('admin.users.ban', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Ban this user?')">
                                        <i class="bi bi-x-octagon"></i> Ban
                                    </button>
                                </form>
                            @endif
                            @if($user->status !== 'active')
                                <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bi bi-check-circle"></i> Activate
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $users->links() }}
    </div>
@else
    <div class="alert alert-info">
        <p>No users found.</p>
    </div>
@endif

<div class="mt-3">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection

