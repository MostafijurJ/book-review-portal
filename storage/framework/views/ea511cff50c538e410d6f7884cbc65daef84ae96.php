<?php $__env->startSection('title', $user->username . ' - Profile - Book Review Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
                <h3><?php echo e($user->username); ?></h3>
                <?php if($user->bio): ?>
                    <p class="text-muted"><?php echo e($user->bio); ?></p>
                <?php endif; ?>
                <?php if(auth()->check() && auth()->id() === $user->id): ?>
                    <a href="<?php echo e(route('profiles.edit')); ?>" class="btn btn-primary">Edit Profile</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <h2>Reviews (<?php echo e($user->reviews->count()); ?>)</h2>
        <?php if($user->reviews->count() > 0): ?>
            <?php $__currentLoopData = $user->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>
                            <a href="<?php echo e(route('books.show', $review->book)); ?>"><?php echo e($review->book->title); ?></a>
                            <span class="text-muted">by <?php echo e($review->book->author); ?></span>
                        </h5>
                        <div class="mb-2">
                            <span class="star-rating">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi bi-star<?php echo e($i <= $review->rating ? '-fill' : ''); ?>"></i>
                                <?php endfor; ?>
                            </span>
                            <small class="text-muted ms-2"><?php echo e($review->created_at->diffForHumans()); ?></small>
                        </div>
                        <p><?php echo e($review->review_text); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <p class="text-muted">No reviews yet.</p>
        <?php endif; ?>

        <h2 class="mt-4">Bookshelves</h2>
        <?php
            $statusLabels = [
                'want_to_read' => 'Want to Read',
                'currently_reading' => 'Currently Reading',
                'read' => 'Read',
            ];
        ?>

        <?php $__currentLoopData = ['want_to_read', 'currently_reading', 'read']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <h4><?php echo e($statusLabels[$status]); ?> (<?php echo e($bookshelves->get($status, collect())->count()); ?>)</h4>
            <?php if($bookshelves->has($status) && $bookshelves->get($status)->count() > 0): ?>
                <div class="row mb-3">
                    <?php $__currentLoopData = $bookshelves->get($status)->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookshelf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-2 mb-2">
                            <a href="<?php echo e(route('books.show', $bookshelf->book)); ?>" class="text-decoration-none">
                                <?php if($bookshelf->book->cover_image): ?>
                                    <img src="<?php echo e($bookshelf->book->cover_image); ?>" class="img-fluid rounded" alt="<?php echo e($bookshelf->book->title); ?>">
                                <?php else: ?>
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height: 100px;">
                                        <i class="bi bi-book text-white"></i>
                                    </div>
                                <?php endif; ?>
                                <small class="d-block text-dark mt-1"><?php echo e(Str::limit($bookshelf->book->title, 20)); ?></small>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-muted">No books in this shelf.</p>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mr/PhpstormProjects/book-review-portal/resources/views/profiles/show.blade.php ENDPATH**/ ?>