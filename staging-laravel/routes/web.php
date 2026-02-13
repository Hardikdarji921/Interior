<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CalculatorController;
use App\Http\Controllers\Frontend\ProjectController as FrontendProjectController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Services
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Portfolio/Projects (Public - your existing portfolio)
Route::get('/portfolio', [ProjectController::class, 'index'])->name('portfolio');
Route::get('/portfolio/{project:slug}', [ProjectController::class, 'show'])->name('portfolio.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Calculator Routes
Route::prefix('calculator')->name('calculator.')->group(function () {
    Route::get('/', [CalculatorController::class, 'index'])->name('index');
    Route::post('/calculate', [CalculatorController::class, 'calculate'])->name('calculate');
    Route::get('/history', [CalculatorController::class, 'history'])->name('history');
    Route::get('/{category}', [CalculatorController::class, 'quickCalculate'])->name('category');
    Route::get('/material/{materialId}/colors', [CalculatorController::class, 'getColors'])->name('colors');
});

// My Projects (Requires Auth) - Calculator Projects
Route::middleware(['auth'])->prefix('my-projects')->name('projects.')->group(function () {
    Route::get('/', [FrontendProjectController::class, 'index'])->name('index');
    Route::get('/create', [FrontendProjectController::class, 'create'])->name('create');
    Route::post('/', [FrontendProjectController::class, 'store'])->name('store');
    Route::get('/{project}', [FrontendProjectController::class, 'show'])->name('show');
    Route::delete('/{project}', [FrontendProjectController::class, 'destroy'])->name('destroy');
    Route::post('/{project}/items', [FrontendProjectController::class, 'addItem'])->name('items.add');
    Route::delete('/{project}/items/{item}', [FrontendProjectController::class, 'removeItem'])->name('items.remove');
    Route::post('/{project}/coupon', [FrontendProjectController::class, 'applyCoupon'])->name('coupon.apply');
    Route::get('/{project}/quotation', [FrontendProjectController::class, 'downloadQuotation'])->name('quotation');
    Route::patch('/{project}/status', [FrontendProjectController::class, 'updateStatus'])->name('status');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', function() {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('materials', MaterialController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('coupons', CouponController::class);
});