<?php $__env->startSection('title', 'My Bookshelves - Book Review Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <h1>My Bookshelves</h1>
    </div>
</div>

<?php
    $statusLabels = [
        'want_to_read' => 'Want to Read',
        'currently_reading' => 'Currently Reading',
        'read' => 'Read',
    ];
?>

<?php $__currentLoopData = ['want_to_read', 'currently_reading', 'read']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="row mb-5">
        <div class="col-12">
            <h3><?php echo e($statusLabels[$status]); ?> (<?php echo e($bookshelves->get($status, collect())->count()); ?>)</h3>
            <?php if($bookshelves->has($status) && $bookshelves->get($status)->count() > 0): ?>
                <div class="row">
                    <?php $__currentLoopData = $bookshelves->get($status); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookshelf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3 col-lg-2 mb-4">
                            <div class="card book-card h-100">
                                <a href="<?php echo e(route('books.show', $bookshelf->book)); ?>" class="text-decoration-none">
                                    <?php if($bookshelf->book->cover_image): ?>
                                        <img src="<?php echo e($bookshelf->book->cover_image); ?>" class="card-img-top" alt="<?php echo e($bookshelf->book->title); ?>" style="height: 200px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="bi bi-book text-white" style="font-size: 3rem;"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h6 class="card-title text-dark"><?php echo e(Str::limit($bookshelf->book->title, 30)); ?></h6>
                                        <p class="card-text text-muted small"><?php echo e(Str::limit($bookshelf->book->author, 25)); ?></p>
                                    </div>
                                </a>
                                <div class="card-footer">
                                    <form action="<?php echo e(route('bookshelves.destroy', $bookshelf)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100" 
                                                onclick="return confirm('Remove from shelf?')">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-muted">No books in this shelf yet.</p>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mr/PhpstormProjects/book-review-portal/resources/views/bookshelves/index.blade.php ENDPATH**/ ?>