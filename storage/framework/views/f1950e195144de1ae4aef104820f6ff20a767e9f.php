<?php $__env->startSection('title', $genre . ' Books - Book Review Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <h1><?php echo e($genre); ?> Books</h1>
        <p><a href="<?php echo e(route('books.index')); ?>">← Back to all books</a></p>
    </div>
</div>

<?php if($books->count() > 0): ?>
    <div class="row">
        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 col-lg-2 mb-4">
                <div class="card book-card h-100">
                    <a href="<?php echo e(route('books.show', $book)); ?>" class="text-decoration-none">
                        <?php if($book->cover_image): ?>
                            <img src="<?php echo e($book->cover_image); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo e($book->title); ?>" 
                                 style="height: 200px; object-fit: cover; background-color: #f8f9fa;"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'200\'%3E%3Crect fill=\'%23dee2e6\' width=\'200\' height=\'200\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial\' font-size=\'14\' fill=\'%236c757d\'%3E<?php echo e(Str::limit($book->title, 20)); ?>%3C/text%3E%3C/svg%3E'; this.style.objectFit='contain';">
                        <?php else: ?>
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-book text-white" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title text-dark"><?php echo e(Str::limit($book->title, 30)); ?></h6>
                            <p class="card-text text-muted small"><?php echo e(Str::limit($book->author, 25)); ?></p>
                            <?php if($book->average_rating > 0): ?>
                                <div class="d-flex align-items-center">
                                    <span class="star-rating">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?php echo e($i <= round($book->average_rating) ? '-fill' : ''); ?>"></i>
                                        <?php endfor; ?>
                                    </span>
                                    <small class="text-muted ms-2"><?php echo e(number_format($book->average_rating, 1)); ?></small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="row">
        <div class="col-12">
            <?php echo e($books->links()); ?>

        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <p>No books found in this genre.</p>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mr/PhpstormProjects/book-review-portal/resources/views/books/genre.blade.php ENDPATH**/ ?>