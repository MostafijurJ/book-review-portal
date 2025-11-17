<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookshelfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Book Routes
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/genre/{genre}', [BookController::class, 'genre'])->name('books.genre');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Review Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{review}/report', [ReviewController::class, 'report'])->name('reviews.report');
});

// Bookshelf Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/my-bookshelves', [BookshelfController::class, 'index'])->name('bookshelves.index');
    Route::post('/books/{book}/bookshelf', [BookshelfController::class, 'store'])->name('bookshelves.store');
    Route::put('/bookshelves/{bookshelf}', [BookshelfController::class, 'update'])->name('bookshelves.update');
    Route::delete('/bookshelves/{bookshelf}', [BookshelfController::class, 'destroy'])->name('bookshelves.destroy');
});

// Profile Routes
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profiles.show');
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profiles.update');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::post('/reports/{report}/resolve', [AdminController::class, 'resolveReport'])->name('reports.resolve');
    Route::post('/reports/{report}/dismiss', [AdminController::class, 'dismissReport'])->name('reports.dismiss');
    
    // Book Management
    Route::resource('books', \App\Http\Controllers\Admin\BookManagementController::class);
    
    // Author Management
    Route::get('/authors', [\App\Http\Controllers\Admin\AuthorManagementController::class, 'index'])->name('authors.index');
    Route::get('/authors/{author}/edit', [\App\Http\Controllers\Admin\AuthorManagementController::class, 'edit'])->name('authors.edit');
    Route::put('/authors/{author}', [\App\Http\Controllers\Admin\AuthorManagementController::class, 'update'])->name('authors.update');
    Route::delete('/authors/{author}', [\App\Http\Controllers\Admin\AuthorManagementController::class, 'destroy'])->name('authors.destroy');
    
    // Genre Management
    Route::get('/genres', [\App\Http\Controllers\Admin\GenreManagementController::class, 'index'])->name('genres.index');
    Route::get('/genres/create', [\App\Http\Controllers\Admin\GenreManagementController::class, 'create'])->name('genres.create');
    Route::post('/genres', [\App\Http\Controllers\Admin\GenreManagementController::class, 'store'])->name('genres.store');
    Route::get('/genres/{genre}/edit', [\App\Http\Controllers\Admin\GenreManagementController::class, 'edit'])->name('genres.edit');
    Route::put('/genres/{genre}', [\App\Http\Controllers\Admin\GenreManagementController::class, 'update'])->name('genres.update');
    Route::delete('/genres/{genre}', [\App\Http\Controllers\Admin\GenreManagementController::class, 'destroy'])->name('genres.destroy');
    
    // User Management
    Route::get('/users', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserManagementController::class, 'update'])->name('users.update');
    Route::post('/users/{user}/suspend', [\App\Http\Controllers\Admin\UserManagementController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/ban', [\App\Http\Controllers\Admin\UserManagementController::class, 'ban'])->name('users.ban');
    Route::post('/users/{user}/activate', [\App\Http\Controllers\Admin\UserManagementController::class, 'activate'])->name('users.activate');
});

