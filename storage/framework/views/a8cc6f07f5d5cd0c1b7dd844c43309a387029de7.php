<?php $__env->startSection('title', $book->title . ' - Book Review Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4 fade-in">
    <div class="col-12 mb-3">
        <a href="<?php echo e(route('books.index')); ?>" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Books
        </a>
    </div>
</div>

<div class="row mb-4 fade-in">
    <div class="col-md-4 col-lg-3">
        <div class="card shadow-lg border-0 sticky-top" style="top: 100px;">
            <div class="card-body p-0">
                <?php if($book->cover_image): ?>
                    <img src="<?php echo e($book->cover_image); ?>" 
                         class="img-fluid w-100" 
                         alt="<?php echo e($book->title); ?>"
                         style="max-height: 450px; object-fit: contain; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);"
                         onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'300\' height=\'450\'%3E%3Crect fill=\'%23dee2e6\' width=\'300\' height=\'450\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial\' font-size=\'18\' fill=\'%236c757d\'%3E<?php echo e($book->title); ?>%3C/text%3E%3C/svg%3E'; this.style.background='linear-gradient(135deg, #dee2e6 0%, #ced4da 100%)';">
                <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center" 
                         style="height: 450px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="text-center text-white">
                            <i class="bi bi-book" style="font-size: 5rem;"></i>
                            <p class="mt-3 mb-0 fw-semibold"><?php echo e($book->title); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if(auth()->guard()->check()): ?>
                <div class="card-footer bg-white border-top">
                    <form action="<?php echo e(route('bookshelves.store', $book)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <select name="status" class="form-select mb-2" onchange="this.form.submit()">
                            <option value="">Add to Shelf</option>
                            <option value="want_to_read" <?php echo e($userBookshelf && $userBookshelf->status == 'want_to_read' ? 'selected' : ''); ?>>
                                📖 Want to Read
                            </option>
                            <option value="currently_reading" <?php echo e($userBookshelf && $userBookshelf->status == 'currently_reading' ? 'selected' : ''); ?>>
                                📚 Currently Reading
                            </option>
                            <option value="read" <?php echo e($userBookshelf && $userBookshelf->status == 'read' ? 'selected' : ''); ?>>
                                ✅ Read
                            </option>
                        </select>
                    </form>
                    <?php if($userBookshelf): ?>
                        <form action="<?php echo e(route('bookshelves.destroy', $userBookshelf)); ?>" method="POST" class="d-inline w-100">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="bi bi-trash"></i> Remove from Shelf
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-8 col-lg-9">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="flex-grow-1">
                        <h1 class="fw-bold mb-2"><?php echo e($book->title); ?></h1>
                        <h4 class="text-muted mb-3">
                            <i class="bi bi-person"></i> by <?php echo e($book->author); ?>

                        </h4>
                    </div>
                </div>

                <?php if($book->average_rating > 0): ?>
                    <div class="mb-4 p-3 rounded" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                        <div class="d-flex align-items-center">
                            <span class="star-rating fs-3 me-3">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi bi-star<?php echo e($i <= round($book->average_rating) ? '-fill' : ''); ?>"></i>
                                <?php endfor; ?>
                            </span>
                            <div>
                                <div class="fw-bold fs-4"><?php echo e(number_format($book->average_rating, 2)); ?></div>
                                <small class="text-muted">from <?php echo e($book->total_reviews); ?> <?php echo e(Str::plural('review', $book->total_reviews)); ?></small>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row mb-4">
                    <?php if($book->genre): ?>
                        <div class="col-auto mb-2">
                            <span class="badge bg-primary px-3 py-2">
                                <i class="bi bi-tag"></i> 
                                <a href="<?php echo e(route('books.genre', $book->genre)); ?>" class="text-white text-decoration-none"><?php echo e($book->genre); ?></a>
                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if($book->publication_date): ?>
                        <div class="col-auto mb-2">
                            <span class="badge bg-info px-3 py-2">
                                <i class="bi bi-calendar"></i> <?php echo e($book->publication_date->format('Y')); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if($book->page_count): ?>
                        <div class="col-auto mb-2">
                            <span class="badge bg-secondary px-3 py-2">
                                <i class="bi bi-file-text"></i> <?php echo e($book->page_count); ?> pages
                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if($book->synopsis): ?>
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-3">
                            <i class="bi bi-file-text text-primary me-2"></i>Synopsis
                        </h5>
                        <p class="lead" style="line-height: 1.8; color: #4b5563;"><?php echo e($book->synopsis); ?></p>
                    </div>
                <?php endif; ?>

                <?php if($book->publication_date || $book->publisher || $book->page_count): ?>
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h5 class="fw-semibold mb-3">
                                <i class="bi bi-info-circle text-primary me-2"></i>Book Details
                            </h5>
                            <div class="row">
                                <?php if($book->publication_date): ?>
                                    <div class="col-md-6 mb-2">
                                        <strong><i class="bi bi-calendar-event"></i> Published:</strong>
                                        <span class="text-muted"><?php echo e($book->publication_date->format('F j, Y')); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if($book->publisher): ?>
                                    <div class="col-md-6 mb-2">
                                        <strong><i class="bi bi-building"></i> Publisher:</strong>
                                        <span class="text-muted"><?php echo e($book->publisher); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if($book->page_count): ?>
                                    <div class="col-md-6 mb-2">
                                        <strong><i class="bi bi-file-text"></i> Pages:</strong>
                                        <span class="text-muted"><?php echo e(number_format($book->page_count)); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if($book->isbn): ?>
                                    <div class="col-md-6 mb-2">
                                        <strong><i class="bi bi-upc"></i> ISBN:</strong>
                                        <span class="text-muted"><?php echo e($book->isbn); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Write Review Section -->
<?php if(auth()->guard()->check()): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Write Your Review</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('reviews.store', $book)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div>
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <input type="radio" class="btn-check" name="rating" id="rating<?php echo e($i); ?>" value="<?php echo e($i); ?>" <?php echo e(old('rating') == $i ? 'checked' : ($i == 5 ? 'checked' : '')); ?>>
                                    <label class="btn btn-outline-warning" for="rating<?php echo e($i); ?>">
                                        <i class="bi bi-star-fill"></i> <?php echo e($i); ?>

                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="review_text" class="form-label">Your Review</label>
                            <textarea class="form-control <?php $__errorArgs = ['review_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="review_text" name="review_text" rows="5" required><?php echo e(old('review_text')); ?></textarea>
                            <?php $__errorArgs = ['review_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <a href="<?php echo e(route('login')); ?>">Login</a> or <a href="<?php echo e(route('register')); ?>">Sign up</a> to write a review.
    </div>
<?php endif; ?>

<!-- Reviews Section -->
<div class="row">
    <div class="col-12">
        <h3>Reviews</h3>
        <?php if($book->reviews->count() > 0): ?>
            <?php $__currentLoopData = $book->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-0">
                                    <a href="<?php echo e(route('profiles.show', $review->user)); ?>" class="text-decoration-none">
                                        <?php echo e($review->user->username); ?>

                                    </a>
                                </h6>
                                <small class="text-muted"><?php echo e($review->created_at->diffForHumans()); ?></small>
                            </div>
                            <div>
                                <span class="star-rating">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star<?php echo e($i <= $review->rating ? '-fill' : ''); ?>"></i>
                                    <?php endfor; ?>
                                </span>
                            </div>
                        </div>
                        <p class="mb-0"><?php echo e($review->review_text); ?></p>
                        <div class="mt-2">
                            <?php if(auth()->guard()->check()): ?>
                                <?php if($review->user_id !== auth()->id()): ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" data-bs-target="#reportModal<?php echo e($review->id); ?>">
                                        <i class="bi bi-flag"></i> Report
                                    </button>
                                <?php else: ?>
                                    <form action="<?php echo e(route('reviews.destroy', $review)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Are you sure you want to delete this review?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Report Modal -->
                <?php if(auth()->guard()->check()): ?>
                    <?php if($review->user_id !== auth()->id()): ?>
                        <div class="modal fade" id="reportModal<?php echo e($review->id); ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="<?php echo e(route('reviews.report', $review)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="modal-header">
                                            <h5 class="modal-title">Report Review</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Reason</label>
                                                <select name="reason" class="form-select" required>
                                                    <option value="spam">Spam</option>
                                                    <option value="inappropriate">Inappropriate Content</option>
                                                    <option value="harassment">Harassment</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description (optional)</label>
                                                <textarea name="description" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Submit Report</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="alert alert-info">
                <p>No reviews yet. Be the first to review this book!</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mr/PhpstormProjects/book-review-portal/resources/views/books/show.blade.php ENDPATH**/ ?>