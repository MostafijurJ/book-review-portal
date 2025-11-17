<?php $__env->startSection('title', 'Manage Books - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h1>Manage Books</h1>
        <a href="<?php echo e(route('admin.books.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Book
        </a>
    </div>
</div>

<?php if($books->count() > 0): ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Reviews</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($book->title); ?></td>
                        <td><?php echo e($book->author); ?></td>
                        <td><?php echo e($book->genre ?? 'N/A'); ?></td>
                        <td><?php echo e($book->reviews_count); ?></td>
                        <td>
                            <?php if($book->average_rating > 0): ?>
                                <span class="star-rating">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star<?php echo e($i <= round($book->average_rating) ? '-fill' : ''); ?>"></i>
                                    <?php endfor; ?>
                                </span>
                                <?php echo e(number_format($book->average_rating, 1)); ?>

                            <?php else: ?>
                                No ratings
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.books.edit', $book)); ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="<?php echo e(route('admin.books.destroy', $book)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Are you sure you want to delete this book?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <?php echo e($books->links()); ?>

    </div>
<?php else: ?>
    <div class="alert alert-info">
        <p>No books found.</p>
    </div>
<?php endif; ?>

<div class="mt-3">
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">Back to Dashboard</a>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mr/PhpstormProjects/book-review-portal/resources/views/admin/books/index.blade.php ENDPATH**/ ?>