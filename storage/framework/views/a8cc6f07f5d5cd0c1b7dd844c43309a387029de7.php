<?php $__env->startSection('title', $book->title . ' - Book Review Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-3">
        <?php if($book->cover_image): ?>
            <img src="<?php echo e($book->cover_image); ?>" 
                 class="img-fluid rounded shadow-sm" 
                 alt="<?php echo e($book->title); ?>"
                 style="max-height: 400px; width: 100%; object-fit: contain; background-color: #f8f9fa;"
                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'300\' height=\'400\'%3E%3Crect fill=\'%23dee2e6\' width=\'300\' height=\'400\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial\' font-size=\'18\' fill=\'%236c757d\'%3E<?php echo e($book->title); ?>%3C/text%3E%3C/svg%3E'; this.style.backgroundColor='#dee2e6';">
        <?php else: ?>
            <div class="bg-secondary rounded d-flex align-items-center justify-content-center shadow-sm" style="height: 400px; min-height: 400px;">
                <div class="text-center text-white">
                    <i class="bi bi-book" style="font-size: 5rem;"></i>
                    <p class="mt-2 mb-0"><?php echo e($book->title); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if(auth()->guard()->check()): ?>
            <div class="mt-3">
                <form action="<?php echo e(route('bookshelves.store', $book)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <select name="status" class="form-select mb-2" onchange="this.form.submit()">
                        <option value="">Add to Shelf</option>
                        <option value="want_to_read" <?php echo e($userBookshelf && $userBookshelf->status == 'want_to_read' ? 'selected' : ''); ?>>
                            Want to Read
                        </option>
                        <option value="currently_reading" <?php echo e($userBookshelf && $userBookshelf->status == 'currently_reading' ? 'selected' : ''); ?>>
                            Currently Reading
                        </option>
                        <option value="read" <?php echo e($userBookshelf && $userBookshelf->status == 'read' ? 'selected' : ''); ?>>
                            Read
                        </option>
                    </select>
                </form>
                <?php if($userBookshelf): ?>
                    <form action="<?php echo e(route('bookshelves.destroy', $userBookshelf)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger">Remove from Shelf</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-9">
        <h1><?php echo e($book->title); ?></h1>
        <h4 class="text-muted">by <?php echo e($book->author); ?></h4>

        <?php if($book->average_rating > 0): ?>
            <div class="mb-3">
                <span class="star-rating fs-4">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <i class="bi bi-star<?php echo e($i <= round($book->average_rating) ? '-fill' : ''); ?>"></i>
                    <?php endfor; ?>
                </span>
                <span class="ms-2"><?php echo e(number_format($book->average_rating, 2)); ?> (<?php echo e($book->total_reviews); ?> reviews)</span>
            </div>
        <?php endif; ?>

        <?php if($book->genre): ?>
            <p><strong>Genre:</strong> <a href="<?php echo e(route('books.genre', $book->genre)); ?>"><?php echo e($book->genre); ?></a></p>
        <?php endif; ?>

        <?php if($book->synopsis): ?>
            <div class="mb-3">
                <h5>Synopsis</h5>
                <p><?php echo e($book->synopsis); ?></p>
            </div>
        <?php endif; ?>

        <?php if($book->publication_date || $book->publisher || $book->page_count): ?>
            <div class="mb-3">
                <h5>Details</h5>
                <ul class="list-unstyled">
                    <?php if($book->publication_date): ?>
                        <li><strong>Published:</strong> <?php echo e($book->publication_date->format('F Y')); ?></li>
                    <?php endif; ?>
                    <?php if($book->publisher): ?>
                        <li><strong>Publisher:</strong> <?php echo e($book->publisher); ?></li>
                    <?php endif; ?>
                    <?php if($book->page_count): ?>
                        <li><strong>Pages:</strong> <?php echo e($book->page_count); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>
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