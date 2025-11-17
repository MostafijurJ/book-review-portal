<?php $__env->startSection('title', 'Browse Books - Book Review Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <h1>Browse Books</h1>
    </div>
</div>

<!-- Search and Filters -->
<div class="row mb-4">
    <div class="col-md-8">
        <form action="<?php echo e(route('books.index')); ?>" method="GET" class="d-flex">
            <input type="text" class="form-control me-2" name="search" 
                   placeholder="Search by title or author..." value="<?php echo e(request('search')); ?>">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Search
            </button>
        </form>
    </div>
    <div class="col-md-4">
        <?php if($genres->count() > 0): ?>
            <select class="form-select" onchange="if(this.value) window.location.href='<?php echo e(route('books.index')); ?>?genre='+this.value">
                <option value="">All Genres</option>
                <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($genre); ?>" <?php echo e(request('genre') == $genre ? 'selected' : ''); ?>>
                        <?php echo e($genre); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        <?php endif; ?>
    </div>
</div>

<!-- Books Grid -->
<?php if($books->count() > 0): ?>
    <div class="row">
        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 col-lg-2 mb-4">
                <div class="card book-card h-100">
                    <a href="<?php echo e(route('books.show', $book)); ?>" class="text-decoration-none">
                        <?php if($book->cover_image): ?>
                            <img src="<?php echo e($book->cover_image); ?>" class="card-img-top" alt="<?php echo e($book->title); ?>" style="height: 200px; object-fit: cover;">
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

    <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            <?php echo e($books->links()); ?>

        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <h5>No books found</h5>
        <p>Try adjusting your search criteria or browse by genre.</p>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mr/PhpstormProjects/book-review-portal/resources/views/books/index.blade.php ENDPATH**/ ?>