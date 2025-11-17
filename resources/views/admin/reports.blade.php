@extends('layouts.app')

@section('title', 'All Reports - Admin - Book Review Portal')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1>All Reports</h1>
        <p><a href="{{ route('admin.dashboard') }}">← Back to Dashboard</a></p>
    </div>
</div>

@if($reports->count() > 0)
    @foreach($reports as $report)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge bg-{{ $report->status === 'pending' ? 'warning' : ($report->status === 'resolved' ? 'success' : 'secondary') }}">
                            {{ ucfirst($report->status) }}
                        </span>
                        <h5 class="mt-2">Reported by: {{ $report->user->username }}</h5>
                        <p><strong>Reason:</strong> {{ ucfirst($report->reason) }}</p>
                        @if($report->description)
                            <p><strong>Description:</strong> {{ $report->description }}</p>
                        @endif
                        <p class="text-muted small">
                            Reported {{ $report->created_at->diffForHumans() }}
                            @if($report->resolved_at)
                                | Resolved {{ $report->resolved_at->diffForHumans() }} by {{ $report->resolver->username ?? 'Admin' }}
                            @endif
                        </p>
                        
                        @if($report->reportable instanceof \App\Models\Review)
                            <div class="mt-3 p-3 bg-light rounded">
                                <h6>Review Content:</h6>
                                <p><strong>Book:</strong> {{ $report->reportable->book->title }}</p>
                                <p><strong>Reviewer:</strong> {{ $report->reportable->user->username }}</p>
                                <p>{{ $report->reportable->review_text }}</p>
                            </div>
                        @endif
                    </div>
                    @if($report->status === 'pending')
                        <div>
                            <form action="{{ route('admin.reports.resolve', $report) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Are you sure you want to delete this content?')">
                                    <i class="bi bi-trash"></i> Delete Content
                                </button>
                            </form>
                            <form action="{{ route('admin.reports.dismiss', $report) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Dismiss
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <div class="mt-3">
        {{ $reports->links() }}
    </div>
@else
    <div class="alert alert-info">
        <p>No reports found.</p>
    </div>
@endif
@endsection

