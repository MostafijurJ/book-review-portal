<?php $__env->startSection('title', 'Browse Books - Book Review Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4 fade-in">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="fw-bold mb-2">
                    <i class="bi bi-book-half text-primary me-2"></i>Browse Books
                </h1>
                <p class="text-muted mb-0">Discover your next great read</p>
            </div>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Home
            </a>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="row mb-4 fade-in">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="<?php echo e(route('books.index')); ?>" method="GET">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0" 
                                       name="search" 
                                       placeholder="Search by title or author..." 
                                       value="<?php echo e(request('search')); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <?php if($genres->count() > 0): ?>
                                <select class="form-select form-select-lg" 
                                        onchange="if(this.value) window.location.href='<?php echo e(route('books.index')); ?>?genre='+this.value">
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
                    <?php if(request('search') || request('genre')): ?>
                        <div class="mt-3">
                            <a href="<?php echo e(route('books.index')); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Clear Filters
                            </a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Books Grid -->
<?php if($books->count() > 0): ?>
    <div class="row g-4 fade-in">
        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card book-card h-100 border-0">
                    <a href="<?php echo e(route('books.show', $book)); ?>" class="text-decoration-none text-dark">
                        <div class="position-relative">
                            <?php if($book->cover_image): ?>
                                <img src="<?php echo e($book->cover_image); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo e($book->title); ?>" 
                                     style="height: 280px; object-fit: cover; background-color: #f8f9fa;"
                                     onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'280\'%3E%3Crect fill=\'%23dee2e6\' width=\'200\' height=\'280\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial\' font-size=\'14\' fill=\'%236c757d\'%3E<?php echo e(Str::limit($book->title, 20)); ?>%3C/text%3E%3C/svg%3E'; this.style.objectFit='contain';">
                            <?php else: ?>
                                <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" 
                                     style="height: 280px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="bi bi-book text-white" style="font-size: 4rem;"></i>
                                </div>
                            <?php endif; ?>
                            <?php if($book->average_rating > 0): ?>
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 shadow-sm">
                                    <i class="bi bi-star-fill"></i> <?php echo e(number_format($book->average_rating, 1)); ?>

                                </span>
                            <?php endif; ?>
                            <?php if($book->genre): ?>
                                <span class="badge bg-primary position-absolute bottom-0 start-0 m-2 shadow-sm">
                                    <?php echo e($book->genre); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="card-title fw-semibold mb-2" style="font-size: 0.95rem; line-height: 1.3; min-height: 2.6rem;">
                                <?php echo e(Str::limit($book->title, 40)); ?>

                            </h6>
                            <p class="card-text text-muted small mb-2"><?php echo e(Str::limit($book->author, 30)); ?></p>
                            <?php if($book->average_rating > 0): ?>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="star-rating" style="font-size: 0.85rem;">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?php echo e($i <= round($book->average_rating) ? '-fill' : ''); ?>"></i>
                                        <?php endfor; ?>
                                    </span>
                                    <small class="text-muted">(<?php echo e($book->total_reviews); ?>)</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php echo e($books->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="card shadow-sm fade-in">
        <div class="card-body text-center p-5">
            <i class="bi bi-book-x" style="font-size: 4rem; color: #9ca3af;"></i>
            <h4 class="mt-3 mb-2">No books found</h4>
            <p class="text-muted mb-4">Try adjusting your search criteria or browse by genre.</p>
            <a href="<?php echo e(route('books.index')); ?>" class="btn btn-primary">
                <i class="bi bi-arrow-clockwise"></i> View All Books
            </a>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mr/PhpstormProjects/book-review-portal/resources/views/books/index.blade.php ENDPATH**/ ?>