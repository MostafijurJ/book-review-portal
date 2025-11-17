<?php $__env->startSection('title', 'All Reports - Admin - Book Review Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <h1>All Reports</h1>
        <p><a href="<?php echo e(route('admin.dashboard')); ?>">← Back to Dashboard</a></p>
    </div>
</div>

<?php if($reports->count() > 0): ?>
    <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge bg-<?php echo e($report->status === 'pending' ? 'warning' : ($report->status === 'resolved' ? 'success' : 'secondary')); ?>">
                            <?php echo e(ucfirst($report->status)); ?>

                        </span>
                        <h5 class="mt-2">Reported by: <?php echo e($report->user->username); ?></h5>
                        <p><strong>Reason:</strong> <?php echo e(ucfirst($report->reason)); ?></p>
                        <?php if($report->description): ?>
                            <p><strong>Description:</strong> <?php echo e($report->description); ?></p>
                        <?php endif; ?>
                        <p class="text-muted small">
                            Reported <?php echo e($report->created_at->diffForHumans()); ?>

                            <?php if($report->resolved_at): ?>
                                | Resolved <?php echo e($report->resolved_at->diffForHumans()); ?> by <?php echo e($report->resolver->username ?? 'Admin'); ?>

                            <?php endif; ?>
                        </p>
                        
                        <?php if($report->reportable instanceof \App\Models\Review): ?>
                            <div class="mt-3 p-3 bg-light rounded">
                                <h6>Review Content:</h6>
                                <p><strong>Book:</strong> <?php echo e($report->reportable->book->title); ?></p>
                                <p><strong>Reviewer:</strong> <?php echo e($report->reportable->user->username); ?></p>
                                <p><?php echo e($report->reportable->review_text); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if($report->status === 'pending'): ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="mt-3">
        <?php echo e($reports->links()); ?>

    </div>
<?php else: ?>
    <div class="alert alert-info">
        <p>No reports found.</p>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mr/PhpstormProjects/book-review-portal/resources/views/admin/reports.blade.php ENDPATH**/ ?>