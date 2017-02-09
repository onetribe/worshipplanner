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

Route::get('/sets/{set}/songs', 'SetsController@songs')
    ->name('sets.songs')
    ->middleware('can:view,set');
/*
|--------------------------------------------------------------------------
| Songs
|--------------------------------------------------------------------------
*/
Route::get('/songs', 'SongsController@index')
    ->name('songs.index');
    
Route::get('/songs/edit/{song}', 'SongsController@edit')
    ->name('songs.edit')
    ->middleware('can:update,song');

Route::put('/songs/update/{song}', 'SongsController@update')
    ->name('songs.update')
    ->middleware('can:update,song');

Route::post('/songs/store', 'SongsController@store')
    ->name('songs.store')
    ->middleware('can:create,App\Song');

Route::get('/songs/delete/{song}', 'SongsController@destroy')
    ->name('songs.delete')
    ->middleware('can:delete,song');

/*
|--------------------------------------------------------------------------
| Set Songs
|--------------------------------------------------------------------------
*/

Route::post('/set_songs/store', 'SetSongsController@store')
    ->name('set_songs.store')
    ->middleware('can:create,App\SetSong');

Route::post('/set_songs/order/{set}', 'SetSongsController@order')
    ->name('set_songs.order')
    ->middleware('can:update,set');

Route::get('/set_songs/delete/{setSong}', 'SetSongsController@destroy')
    ->name('set_songs.delete')
    ->middleware('can:delete,setSong');

Route::post('/set_songs/update/{setSong}', 'SetSongsController@update')
    ->name('set_songs.update')
    ->middleware('can:update,setSong');
