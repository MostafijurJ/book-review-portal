@extends('layouts.app')

@section('title', 'Admin Dashboard - Book Review Portal')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1>Admin Dashboard</h1>
    </div>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Reports</h5>
                <h2>{{ $stats['total_reports'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pending Reports</h5>
                <h2 class="text-warning">{{ $stats['pending_reports'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Books</h5>
                <h2>{{ $stats['total_books'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <h2>{{ $stats['total_users'] }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Rating Distribution Pie Chart -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Book Rating Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="ratingChart" style="max-height: 300px;"></canvas>
                <div class="mt-3">
                    <small class="text-muted">Total Reviews: {{ $totalReviews }}</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Access</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ route('admin.books.index') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-book"></i> Manage Books
                    </a>
                    <a href="{{ route('admin.authors.index') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-person-badge"></i> Manage Authors
                    </a>
                    <a href="{{ route('admin.genres.index') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-tags"></i> Manage Genres
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-people"></i> Manage Users
                    </a>
                    <a href="{{ route('admin.reports') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-flag"></i> View All Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Reports -->
<div class="row">
    <div class="col-12">
        <h3>Pending Reports</h3>
        @if($pendingReports->count() > 0)
            @foreach($pendingReports as $report)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5>Reported by: {{ $report->user->username }}</h5>
                                <p><strong>Reason:</strong> {{ ucfirst($report->reason) }}</p>
                                @if($report->description)
                                    <p><strong>Description:</strong> {{ $report->description }}</p>
                                @endif
                                <p class="text-muted small">Reported {{ $report->created_at->diffForHumans() }}</p>
                                
                                @if($report->reportable instanceof \App\Models\Review)
                                    <div class="mt-3 p-3 bg-light rounded">
                                        <h6>Review Content:</h6>
                                        <p><strong>Book:</strong> {{ $report->reportable->book->title }}</p>
                                        <p><strong>Reviewer:</strong> {{ $report->reportable->user->username }}</p>
                                        <p><strong>Rating:</strong> 
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $report->reportable->rating ? '-fill' : '' }}"></i>
                                            @endfor
                                        </p>
                                        <p>{{ $report->reportable->review_text }}</p>
                                    </div>
                                @endif
                            </div>
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
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-3">
                {{ $pendingReports->links() }}
            </div>
        @else
            <div class="alert alert-success">
                <p>No pending reports. Great job!</p>
            </div>
        @endif
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('admin.reports') }}" class="btn btn-primary">View All Reports</a>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    const ctx = document.getElementById('ratingChart').getContext('2d');
    const ratingChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['5 Stars', '4 Stars', '3 Stars', '2 Stars', '1 Star'],
            datasets: [{
                label: 'Rating Distribution',
                data: [
                    {{ $ratingData[5]['count'] }},
                    {{ $ratingData[4]['count'] }},
                    {{ $ratingData[3]['count'] }},
                    {{ $ratingData[2]['count'] }},
                    {{ $ratingData[1]['count'] }}
                ],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.8)',  // Yellow for 5 stars
                    'rgba(75, 192, 192, 0.8)',  // Teal for 4 stars
                    'rgba(54, 162, 235, 0.8)',  // Blue for 3 stars
                    'rgba(255, 159, 64, 0.8)',   // Orange for 2 stars
                    'rgba(255, 99, 132, 0.8)'    // Red for 1 star
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            const rating = 6 - context.dataIndex; // Reverse order
                            const percentage = {{ json_encode(array_column($ratingData, 'percentage')) }}[context.dataIndex];
                            label += context.parsed + ' reviews (' + percentage + '%)';
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush

