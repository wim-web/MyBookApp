<?php

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

Route::get('/user', function(){
    return Auth::user();
});

Route::get('public/{name}/show', 'BookController@showPublicPage');

Route::patch('books/{book}/status', 'BookController@updateStatus');
Route::resource('books', 'BookController')->only(['index', 'store', 'destroy']);

Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');
Route::post('/register', 'Auth\RegisterController@register');

Route::get('/{any?}', function() {
    return view('index');
})->where('any', '.+');

