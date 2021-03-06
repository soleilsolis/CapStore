<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LogController;


use App\Models\Project;
use App\Models\Like;
use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;



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
		if(! session('log'))
		{
			Log::create([
				'user_id' => Auth::id(),
				'message' => "User ".Auth::id()." logged in"
			]);
	
			session([
				'log' => 1
			]);
		}

		$monthly = Project::select(DB::raw("DATE_FORMAT(created_at, '%M %Y') date"),DB::raw('count(*) as projects'))
		->groupBy('date')
		->limit(12)
		->get();

		return view('dashboard', [
			'latest' => Project::limit(10)->get(),
			'mostLiked' => Project::has('like')->withCount('like')
			->orderBy('like_count', 'desc')
			->paginate(10),
			'projectCount' => Project::all()->count(),
			'monthly' => $monthly,
			'user_type' => User::findOrFail(Auth::id())->type,
			'logs' => Log::take(10)->get()
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
		Route::get('/csv', [ProjectController::class,'csv']);

		Route::get('/logs', [LogController::class,'index'])->name('logs');

		Route::get('/users', [UserController::class,'index'])
				->name('users');
		Route::get('/user/create', [UserController::class,'create'])
				->name('user.create');
		Route::post('/user/delete', [UserController::class,'destroy']);
		Route::post('/user/search', [UserController::class,'search']);
		Route::post('/user/store', [UserController::class,'store']);
	});
});
