<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'handleregister'])->name('handle.register');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'handlelogin'])->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');




Route::get('/validateaccount/{email}', [AdminController::class, 'validateaccount'])->name('validateaccount');
Route::post('/validateaccount', [AdminController::class, 'handlevalidateaccount'])->name('validateaccount.post');




Route::middleware('auth')->group(function () {
    Route::get('/', [AppController::class, 'index'])->name('dashboard');
    Route::prefix('employer')->group(function () {
        Route::get('/index', [EmployerController::class, 'index'])->name('employers.index');
        Route::get('/create', [EmployerController::class, 'create'])->name('employers.create');
        Route::post('/store', [EmployerController::class, 'store'])->name('employers.store');
        Route::get('/edit/{employer}', [EmployerController::class, 'edit'])->name('employers.edit');
        Route::put('/update/{employer}', [EmployerController::class, 'update'])->name('employers.update');
        Route::get('/destroy/{employer}', [EmployerController::class, 'destroy'])->name('employers.destroy');
        Route::get('/search', [EmployerController::class, 'search'])->name('employers.search');
    });



    Route::prefix('departement')->group(function () {
        Route::get('/index', [DepartementController::class, 'index'])->name('departement.index');
        Route::get('/create', [DepartementController::class, 'create'])->name('departement.create');
        Route::post('/store', [DepartementController::class, 'store'])->name('departement.store');
        Route::get('/edit/{departement}', [DepartementController::class, 'edit'])->name('departement.edit');
        Route::put('/update/{departement}', [DepartementController::class, 'update'])->name('departement.update');
        Route::get('/destroy/{departement}', [DepartementController::class, 'destroy'])->name('departement.destroy');
    });

    Route::prefix('configuration')->group(function () {
        Route::get('/', [ConfigurationController::class, 'index'])->name('configuration.index');
        Route::get('/create', [ConfigurationController::class, 'create'])->name('configuration.create');
        Route::post('/store', [ConfigurationController::class, 'store'])->name('configuration.store');
        Route::get('/destroy/{configuration}', [ConfigurationController::class, 'destroy'])->name('configuration.destroy');
    });
    Route::prefix('admin')->group(function () {
        Route::get('/index', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/show/{id}', [AdminController::class, 'show'])->name('admin.show');
        // Route::get('/edit/{admin}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::get('/destroy/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::get('/search', [AdminController::class, 'search'])->name('admin.search');
    });
    Route::prefix('payment')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payment');
        Route::get('/makepayment', [PaymentController::class, 'makepayment'])->name('payment.make');
    });
    Route::get('/download/{payment}', [PaymentController::class, 'download'])->name('payment.download');
});
