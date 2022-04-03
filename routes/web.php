<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;

use App\Models\Project;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/dashboard', function () {
        return view('dashboard', [

        ]);
    })->name('dashboard');

    Route::get('/projects', [ProjectController::class,'index'])->name('projects');

    Route::get('/project/{id}', [ProjectController::class,'show'])
            ->whereNumber('id')
            ->name('project.show');

    Route::get('/project/create', [ProjectController::class,'create'])
            ->name('project.create');

    Route::post('/project/like', [LikeController::class,'store']);

    Route::post('/project/search', [ProjectController::class,'search']);

    Route::post('/project/store', [ProjectController::class,'store']);

    Route::get('/project/edit/{id}', [ProjectController::class,'edit'])
            ->name('project.edit');

    Route::post('/project/update/{id}', [ProjectController::class,'update'])
            ->whereNumber('id');

    Route::post('/project/delete/{id}', [ProjectController::class,'destroy'])
            ->whereNumber('id');

            

    Route::get('/user/{id}', [UserController::class,'show'])
            ->whereNumber('id')
            ->name('user.show'); 

    Route::get('/user/edit/{id}', [UserController::class,'edit'])
			->whereNumber('id')
            ->name('user.edit');

    Route::post('/user/update/{id}', [UserController::class,'update'])
			->whereNumber('id');
       

    Route::middleware('admin')->group(function(){
        Route::get('/users', [UserController::class,'index'])
            ->name('users');
            
        Route::get('/user/create', [UserController::class,'create'])
                ->name('user.create');
        
        Route::post('/user/delete', [UserController::class,'destroy']);

        Route::post('/user/search', [UserController::class,'search']);


        Route::post('/user/store', [UserController::class,'store']);
    });

});
