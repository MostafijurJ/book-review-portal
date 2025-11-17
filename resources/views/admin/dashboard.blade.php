@extends('layouts.app')

@section('title', 'Admin Dashboard - Book Review Portal')

@section('content')
<div class="row mb-4 fade-in">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="fw-bold mb-2">
                    <i class="bi bi-shield-check text-primary me-2"></i>Admin Dashboard
                </h1>
                <p class="text-muted mb-0">Manage your book review portal</p>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="row g-4 mb-4 fade-in">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <i class="bi bi-flag"></i> Total Reports
                    </h6>
                    <h2 class="fw-bold mb-0">{{ $stats['total_reports'] }}</h2>
                </div>
                <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-flag-fill text-danger" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card" style="border-left-color: var(--warning-color);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <i class="bi bi-clock-history"></i> Pending Reports
                    </h6>
                    <h2 class="fw-bold mb-0 text-warning">{{ $stats['pending_reports'] }}</h2>
                </div>
                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-clock-history text-warning" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card" style="border-left-color: var(--info-color);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <i class="bi bi-book"></i> Total Books
                    </h6>
                    <h2 class="fw-bold mb-0">{{ $stats['total_books'] }}</h2>
                </div>
                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-book-fill text-info" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card" style="border-left-color: var(--success-color);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <i class="bi bi-people"></i> Total Users
                    </h6>
                    <h2 class="fw-bold mb-0">{{ $stats['total_users'] }}</h2>
                </div>
                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-people-fill text-success" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rating Distribution Pie Chart -->
<div class="row g-4 mb-4 fade-in">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pie-chart-fill me-2"></i>Book Rating Distribution
                </h5>
            </div>
            <div class="card-body">
                <canvas id="ratingChart" style="max-height: 350px;"></canvas>
                <div class="mt-3 text-center">
                    <span class="badge bg-primary px-3 py-2">
                        <i class="bi bi-star"></i> Total Reviews: {{ $totalReviews }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-lightning-fill me-2"></i>Quick Access
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.books.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                        <i class="bi bi-book text-primary me-3"></i> 
                        <span class="fw-semibold">Manage Books</span>
                        <i class="bi bi-chevron-right float-end text-muted"></i>
                    </a>
                    <a href="{{ route('admin.authors.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                        <i class="bi bi-person-badge text-info me-3"></i> 
                        <span class="fw-semibold">Manage Authors</span>
                        <i class="bi bi-chevron-right float-end text-muted"></i>
                    </a>
                    <a href="{{ route('admin.genres.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                        <i class="bi bi-tags text-success me-3"></i> 
                        <span class="fw-semibold">Manage Genres</span>
                        <i class="bi bi-chevron-right float-end text-muted"></i>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                        <i class="bi bi-people text-warning me-3"></i> 
                        <span class="fw-semibold">Manage Users</span>
                        <i class="bi bi-chevron-right float-end text-muted"></i>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="list-group-item list-group-item-action border-0 py-3">
                        <i class="bi bi-flag text-danger me-3"></i> 
                        <span class="fw-semibold">View All Reports</span>
                        <i class="bi bi-chevron-right float-end text-muted"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Reports -->
<div class="row fade-in">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="fw-bold mb-0">
                <i class="bi bi-exclamation-triangle text-warning me-2"></i>Pending Reports
            </h3>
            <a href="{{ route('admin.reports') }}" class="btn btn-outline-primary">
                View All <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        @if($pendingReports->count() > 0)
            <div class="row g-3">
                @foreach($pendingReports as $report)
                    <div class="col-12">
                        <div class="card shadow-sm border-0 border-start border-warning border-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-person-circle text-primary me-2"></i>
                                            <h6 class="mb-0 fw-semibold">Reported by: {{ $report->user->username }}</h6>
                                            <span class="badge bg-warning text-dark ms-2">{{ ucfirst($report->reason) }}</span>
                                        </div>
                                        @if($report->description)
                                            <p class="mb-2"><strong>Description:</strong> {{ $report->description }}</p>
                                        @endif
                                        <p class="text-muted small mb-3">
                                            <i class="bi bi-clock"></i> Reported {{ $report->created_at->diffForHumans() }}
                                        </p>
                                        
                                        @if($report->reportable instanceof \App\Models\Review)
                                            <div class="card bg-light border-0 mt-3">
                                                <div class="card-body">
                                                    <h6 class="fw-semibold mb-3">
                                                        <i class="bi bi-chat-left-text"></i> Review Content
                                                    </h6>
                                                    <p class="mb-2"><strong>Book:</strong> {{ $report->reportable->book->title }}</p>
                                                    <p class="mb-2"><strong>Reviewer:</strong> {{ $report->reportable->user->username }}</p>
                                                    <p class="mb-2"><strong>Rating:</strong> 
                                                        <span class="star-rating">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="bi bi-star{{ $i <= $report->reportable->rating ? '-fill' : '' }}"></i>
                                                            @endfor
                                                        </span>
                                                    </p>
                                                    <p class="mb-0">{{ $report->reportable->review_text }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <form action="{{ route('admin.reports.resolve', $report) }}" method="POST" class="d-inline mb-2">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to delete this content?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.reports.dismiss', $report) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-x-circle"></i> Dismiss
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $pendingReports->links() }}
            </div>
        @else
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-5">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 mb-2">No pending reports</h4>
                    <p class="text-muted">Great job! All reports have been handled.</p>
                </div>
            </div>
        @endif
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

