<?php $__env->startSection('title', 'Admin Dashboard - Book Review Portal'); ?>

<?php $__env->startSection('content'); ?>
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
                <h2><?php echo e($stats['total_reports']); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pending Reports</h5>
                <h2 class="text-warning"><?php echo e($stats['pending_reports']); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Books</h5>
                <h2><?php echo e($stats['total_books']); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <h2><?php echo e($stats['total_users']); ?></h2>
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
                    <small class="text-muted">Total Reviews: <?php echo e($totalReviews); ?></small>
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
                    <a href="<?php echo e(route('admin.books.index')); ?>" class="list-group-item list-group-item-action">
                        <i class="bi bi-book"></i> Manage Books
                    </a>
                    <a href="<?php echo e(route('admin.authors.index')); ?>" class="list-group-item list-group-item-action">
                        <i class="bi bi-person-badge"></i> Manage Authors
                    </a>
                    <a href="<?php echo e(route('admin.genres.index')); ?>" class="list-group-item list-group-item-action">
                        <i class="bi bi-tags"></i> Manage Genres
                    </a>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="list-group-item list-group-item-action">
                        <i class="bi bi-people"></i> Manage Users
                    </a>
                    <a href="<?php echo e(route('admin.reports')); ?>" class="list-group-item list-group-item-action">
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
        <?php if($pendingReports->count() > 0): ?>
            <?php $__currentLoopData = $pendingReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5>Reported by: <?php echo e($report->user->username); ?></h5>
                                <p><strong>Reason:</strong> <?php echo e(ucfirst($report->reason)); ?></p>
                                <?php if($report->description): ?>
                                    <p><strong>Description:</strong> <?php echo e($report->description); ?></p>
                                <?php endif; ?>
                                <p class="text-muted small">Reported <?php echo e($report->created_at->diffForHumans()); ?></p>
                                
                                <?php if($report->reportable instanceof \App\Models\Review): ?>
                                    <div class="mt-3 p-3 bg-light rounded">
                                        <h6>Review Content:</h6>
                                        <p><strong>Book:</strong> <?php echo e($report->reportable->book->title); ?></p>
                                        <p><strong>Reviewer:</strong> <?php echo e($report->reportable->user->username); ?></p>
                                        <p><strong>Rating:</strong> 
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="bi bi-star<?php echo e($i <= $report->reportable->rating ? '-fill' : ''); ?>"></i>
                                            <?php endfor; ?>
                                        </p>
                                        <p><?php echo e($report->reportable->review_text); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <form action="<?php echo e(route('admin.reports.resolve', $report)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this content?')">
                                        <i class="bi bi-trash"></i> Delete Content
                                    </button>
                                </form>
                                <form action="<?php echo e(route('admin.reports.dismiss', $report)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="bi bi-x-circle"></i> Dismiss
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="mt-3">
                <?php echo e($pendingReports->links()); ?>

            </div>
        <?php else: ?>
            <div class="alert alert-success">
                <p>No pending reports. Great job!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="<?php echo e(route('admin.reports')); ?>" class="btn btn-primary">View All Reports</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
                    <?php echo e($ratingData[5]['count']); ?>,
                    <?php echo e($ratingData[4]['count']); ?>,
                    <?php echo e($ratingData[3]['count']); ?>,
                    <?php echo e($ratingData[2]['count']); ?>,
                    <?php echo e($ratingData[1]['count']); ?>

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
                            const percentage = <?php echo e(json_encode(array_column($ratingData, 'percentage'))); ?>[context.dataIndex];
                            label += context.parsed + ' reviews (' + percentage + '%)';
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mr/PhpstormProjects/book-review-portal/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>