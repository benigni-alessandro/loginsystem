<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Auth::routes(['verify' => true]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])
->group(function () {
    Route::resource('roles', 'App\Http\Controllers\RoleController');
    Route::resource('users', 'App\Http\Controllers\UserController');
    Route::resource('tags', 'App\Http\Controllers\TagController');
    Route::patch('images/share/{image}', 'App\Http\Controllers\ImageController@share')->name('images.share'); 
    Route::resource('images', 'App\Http\Controllers\ImageController'); 
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/register/verify/{code}', 'RegisterController@verify');