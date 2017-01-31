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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/sets', 'SetsController@index')
    ->name('sets.index');

Route::get('/sets/show/{set}', 'SetsController@show')
    ->name('sets.view')
    ->middleware('can:view,set');

Route::post('/sets/store', 'SetsController@store')
    ->name('sets.store')
    ->middleware('can:create,App\Set');

Route::get('/sets/delete/{set}', 'SetsController@destroy')
    ->name('sets.delete')
    ->middleware('can:delete,set');


Route::get('/songs', 'SongsController@index')
    ->name('songs.index');
    
Route::get('/songs/show/{song}', 'SongsController@show')
    ->name('songs.view')
    ->middleware('can:view,song');

Route::post('/songs/store', 'SongsController@store')
    ->name('songs.store')
    ->middleware('can:create,App\Song');

Route::get('/songs/delete/{song}', 'SongsController@destroy')
    ->name('songs.delete')
    ->middleware('can:delete,song');