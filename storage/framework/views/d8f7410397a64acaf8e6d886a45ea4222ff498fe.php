<?php $__env->startSection('title', 'Home - Book Review Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <h1 class="display-4">Welcome to Book Review Portal</h1>
        <p class="lead">Discover, review, and organize your favorite books</p>
    </div>
</div>

<!-- Search Bar -->
<div class="row mb-5">
    <div class="col-md-8 mx-auto">
        <form action="<?php echo e(route('books.index')); ?>" method="GET">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" name="search" placeholder="Search for books by title or author..." value="<?php echo e(request('search')); ?>">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Browse by Genre -->
<?php if($genres->count() > 0): ?>
<div class="row mb-5">
    <div class="col-12">
        <h2 class="mb-3">Browse by Genre</h2>
        <div class="d-flex flex-wrap gap-2">
            <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('books.genre', $genre)); ?>" class="btn btn-outline-primary">
                    <?php echo e($genre); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Featured Books -->
<?php if($featuredBooks->count() > 0): ?>
<div class="row mb-5">
    <div class="col-12">
        <h2 class="mb-3">Top Rated Books</h2>
        <div class="row">
            <?php $__currentLoopData = $featuredBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-lg-2 mb-4">
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
                                <div class="d-flex align-items-center">
                                    <span class="star-rating">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?php echo e($i <= round($book->average_rating) ? '-fill' : ''); ?>"></i>
                                        <?php endfor; ?>
                                    </span>
                                    <small class="text-muted ms-2"><?php echo e(number_format($book->average_rating, 1)); ?></small>
                                </div>
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
<div class="row">
    <div class="col-12">
        <h2 class="mb-3">Recently Added Books</h2>
        <div class="row">
            <?php $__currentLoopData = $recentBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-lg-2 mb-4">
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