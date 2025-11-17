<?php $__env->startSection('title', 'Home - Book Review Portal'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<div class="hero-section fade-in">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h1 class="display-4 fw-bold mb-3">
                <i class="bi bi-book-half me-3"></i>Welcome to Book Review Portal
            </h1>
            <p class="lead mb-4" style="font-size: 1.25rem; opacity: 0.95;">
                Discover, review, and organize your favorite books. Join our community of passionate readers!
            </p>
            <?php if(!auth()->check()): ?>
                <div class="d-flex gap-3">
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-lg">
                        <i class="bi bi-person-plus"></i> Get Started
                    </a>
                    <a href="<?php echo e(route('books.index')); ?>" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-book"></i> Browse Books
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-lg-4 text-center mt-4 mt-lg-0">
            <i class="bi bi-book" style="font-size: 8rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<!-- Search Bar -->
<div class="row mb-5 fade-in">
    <div class="col-md-10 col-lg-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="<?php echo e(route('books.index')); ?>" method="GET">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               name="search" 
                               placeholder="Search for books by title or author..." 
                               value="<?php echo e(request('search')); ?>"
                               style="font-size: 1.1rem;">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="bi bi-search me-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Browse by Genre -->
<?php if($genres->count() > 0): ?>
<div class="row mb-5 fade-in">
    <div class="col-12">
        <div class="d-flex align-items-center mb-4">
            <h2 class="mb-0 me-3">
                <i class="bi bi-tags-fill text-primary me-2"></i>Browse by Genre
            </h2>
            <div class="flex-grow-1" style="height: 2px; background: linear-gradient(90deg, var(--primary-color), transparent);"></div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap gap-2">
                    <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('books.genre', $genre)); ?>" 
                           class="btn btn-outline-primary rounded-pill px-4 py-2">
                            <i class="bi bi-bookmark me-2"></i><?php echo e($genre); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Featured Books -->
<?php if($featuredBooks->count() > 0): ?>
<div class="row mb-5 fade-in">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-star-fill text-warning me-2"></i>Top Rated Books
                </h2>
            </div>
            <a href="<?php echo e(route('books.index')); ?>" class="btn btn-outline-primary">
                View All <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $featuredBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card book-card h-100 border-0">
                        <a href="<?php echo e(route('books.show', $book)); ?>" class="text-decoration-none text-dark">
                            <div class="position-relative">
                                <?php if($book->cover_image): ?>
                                    <img src="<?php echo e($book->cover_image); ?>" 
                                         class="card-img-top" 
                                         alt="<?php echo e($book->title); ?>" 
                                         style="height: 250px; object-fit: cover; background-color: #f8f9fa;"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'250\'%3E%3Crect fill=\'%23dee2e6\' width=\'200\' height=\'250\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial\' font-size=\'14\' fill=\'%236c757d\'%3E<?php echo e(Str::limit($book->title, 20)); ?>%3C/text%3E%3C/svg%3E'; this.style.objectFit='contain';">
                                <?php else: ?>
                                    <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" 
                                         style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <i class="bi bi-book text-white" style="font-size: 4rem;"></i>
                                    </div>
                                <?php endif; ?>
                                <?php if($book->average_rating > 0): ?>
                                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">
                                        <i class="bi bi-star-fill"></i> <?php echo e(number_format($book->average_rating, 1)); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="card-title fw-semibold mb-2" style="font-size: 0.9rem; line-height: 1.3;">
                                    <?php echo e(Str::limit($book->title, 35)); ?>

                                </h6>
                                <p class="card-text text-muted small mb-2"><?php echo e(Str::limit($book->author, 30)); ?></p>
                                <?php if($book->average_rating > 0): ?>
                                    <div class="d-flex align-items-center">
                                        <span class="star-rating" style="font-size: 0.85rem;">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="bi bi-star<?php echo e($i <= round($book->average_rating) ? '-fill' : ''); ?>"></i>
                                            <?php endfor; ?>
                                        </span>
                                        <small class="text-muted ms-2">(<?php echo e($book->total_reviews); ?>)</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Recent Books -->
<?php if($recentBooks->count() > 0): ?>
<div class="row fade-in">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-clock-history text-info me-2"></i>Recently Added Books
                </h2>
            </div>
            <a href="<?php echo e(route('books.index')); ?>" class="btn btn-outline-primary">
                View All <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $recentBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card book-card h-100 border-0">
                        <a href="<?php echo e(route('books.show', $book)); ?>" class="text-decoration-none text-dark">
                            <div class="position-relative">
                                <?php if($book->cover_image): ?>
                                    <img src="<?php echo e($book->cover_image); ?>" 
                                         class="card-img-top" 
                                         alt="<?php echo e($book->title); ?>" 
                                         style="height: 250px; object-fit: cover; background-color: #f8f9fa;"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'250\'%3E%3Crect fill=\'%23dee2e6\' width=\'200\' height=\'250\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial\' font-size=\'14\' fill=\'%236c757d\'%3E<?php echo e(Str::limit($book->title, 20)); ?>%3C/text%3E%3C/svg%3E'; this.style.objectFit='contain';">
                                <?php else: ?>
                                    <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" 
                                         style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <i class="bi bi-book text-white" style="font-size: 4rem;"></i>
                                    </div>
                                <?php endif; ?>
                                <span class="badge bg-info position-absolute top-0 start-0 m-2">
                                    <i class="bi bi-clock"></i> New
                                </span>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="card-title fw-semibold mb-2" style="font-size: 0.9rem; line-height: 1.3;">
                                    <?php echo e(Str::limit($book->title, 35)); ?>

                                </h6>
                                <p class="card-text text-muted small mb-0"><?php echo e(Str::limit($book->author, 30)); ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mr/PhpstormProjects/book-review-portal/resources/views/home.blade.php ENDPATH**/ ?>