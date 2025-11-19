<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('home');
//})->name('home');

Auth::routes([
    "verify" => false,
    "confirm" => false,
    "register" => false
]);

//Route::middleware(['auth','verified'])->group(function() {
//
//    Route::prefix('profile')->group(function() {
//
//        Route::get('/', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
//        Route::post('/update', [App\Http\Controllers\UserController::class, 'update'])->name('profile.update');
//
//    });
//
//});


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/gpa-calculator', [App\Http\Controllers\HomeController::class, 'gpa'])->name('gpa');
Route::get('/absence-calculator', [App\Http\Controllers\HomeController::class, 'absence'])->name('absence');
//Route::get('/absence-calculator2', [App\Http\Controllers\HomeController::class, 'absence2'])->name('absence2');

Route::prefix('group')->group(function() {

    Route::post('/search', [App\Http\Controllers\GroupController::class, 'search'])->name('group.search');
    Route::get('/create', [App\Http\Controllers\GroupController::class, 'showCreate'])->name('group.showCreateForm');
    Route::post('/create', [App\Http\Controllers\GroupController::class, 'create'])->name('group.create');
    Route::get('/{class_number}', [App\Http\Controllers\GroupController::class, 'show'])->name('group.show');
    Route::get('/{class_number}/edit', [App\Http\Controllers\RequestEditController::class, 'showEdit'])->name('group.showEditForm');
    Route::post('/{class_number}/edit', [App\Http\Controllers\RequestEditController::class, 'edit'])->name('group.edit');
    Route::post('/{class_number}/report', [App\Http\Controllers\ReportController::class, 'create'])->name('group.report');

    Route::middleware('admin')->group(function() {
        Route::post('/{class_number}/accept', [App\Http\Controllers\GroupController::class, 'accept'])->name('group.accept');
        Route::post('/{class_number}/delete', [App\Http\Controllers\GroupController::class, 'delete'])->name('group.delete');
    });

});

//Route::prefix('term')->middleware('super_admin')->group(function() {
//
//    Route::get('/', [App\Http\Controllers\TermController::class, 'index'])->name('term');
//    Route::get('/add', [App\Http\Controllers\TermController::class, 'showAdd'])->name('term.showAddForm');
//    Route::post('/add', [App\Http\Controllers\TermController::class, 'add'])->name('term.add');
//
//});

Route::prefix('report')->middleware('admin')->group(function() {

    Route::post('/delete/{id}', [App\Http\Controllers\ReportController::class, 'delete'])->name('report.delete');
    Route::post('/ignore/{id}', [App\Http\Controllers\ReportController::class, 'ignore'])->name('report.ignore');

});

Route::prefix('requests')->middleware('admin')->group(function() {

    Route::post('/accept/{id}', [App\Http\Controllers\RequestEditController::class, 'accept'])->name('request.accept');
    Route::post('/ignore/{id}', [App\Http\Controllers\RequestEditController::class, 'ignore'])->name('request.ignore');

});

Route::prefix('dashboard')->middleware(['auth','admin'])->group(function() {

    Route::get('/', function () {
        return redirect()->route('dashboard.groups');
    })->name('dashboard');
//    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.dashboard');

    Route::prefix('admins')->middleware('super_admin')->group(function() {

        Route::get('/', [App\Http\Controllers\DashboardController::class, 'admins'])->name('dashboard.admins');

        Route::post('/add', [App\Http\Controllers\AdminController::class, 'add'])->name('admins.add');
        Route::post('/delete', [App\Http\Controllers\AdminController::class, 'delete'])->name('admins.delete');

    });

    Route::get('/groups', [App\Http\Controllers\DashboardController::class, 'groups'])->name('dashboard.groups');
    Route::get('/reports', [App\Http\Controllers\DashboardController::class, 'reports'])->name('dashboard.reports');
    Route::get('/editRequests', [App\Http\Controllers\DashboardController::class, 'editRequests'])->name('dashboard.editRequests');

});

Route::any('{catchall}', function () {
    return view('errors.404');
})->where('catchall', '.*');
