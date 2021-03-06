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

Route::get('/', 'HomeController@index');


Auth::routes();
Route::get('/logout', Auth\LoginController::class ."@logout")->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/sets', 'SetsController@index')
    ->name('sets.index');

Route::get('/sets/edit/{set}', 'SetsController@edit')
    ->name('sets.edit')
    ->middleware('can:update,set');

Route::get('/sets/view/{set}', 'SetsController@show')
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

Route::post('/sets/update/{set}', 'SetsController@update')
    ->name('sets.update')
    ->middleware('can:update,set');

Route::get('/sets/members/{set}', 'SetsController@members')
    ->name('sets.members')
    ->middleware('can:update,set');



Route::post('/sets/{set}/user/{user}/role/{bandRole}', 'SetSubscriptionsController@storeWithRole')
    ->name('sets.user.role.add')
    ->middleware('can:update,set');

Route::delete('/sets/{set}/role/{bandRole}', 'SetSubscriptionsController@removeByRole')
    ->name('sets.role.remove')
    ->middleware('can:update,set');

/*
|--------------------------------------------------------------------------
| Songs
|--------------------------------------------------------------------------
*/
Route::get('/songs', 'SongsController@index')
    ->name('songs.index');

Route::get('/songs/view/{song}', 'SongsController@show')
    ->name('songs.view')
    ->middleware('can:view,song');
    
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

Route::delete('/set_songs/{setSong}', 'SetSongsController@destroy')
    ->name('set_songs.delete')
    ->middleware('can:delete,setSong');

Route::post('/set_songs/update/{setSong}', 'SetSongsController@update')
    ->name('set_songs.update')
    ->middleware('can:update,setSong');

Route::post('/set_songs/transpose/{setSong}', 'SetSongsController@transpose')
    ->name('set_songs.transpose')
    ->middleware('can:update,setSong');



/*
|--------------------------------------------------------------------------
| Bands
|--------------------------------------------------------------------------
*/

Route::get('/bands', 'BandsController@index')
    ->name('bands.index');

Route::post('/bands', 'BandsController@store')
    ->name('bands.store')
    ->middleware('can:create,App\BandRole');

Route::get('/bands/{band}', 'BandsController@show')
    ->name('bands.view')
    ->middleware('can:view,band');

Route::put('/bands/{band}', 'BandsController@update')
    ->name('bands.update')
    ->middleware('can:update,band');

Route::delete('/bands/{band}', 'BandsController@destroy')
    ->name('bands.delete')
    ->middleware('can:delete,band');



Route::delete('/bands/{band}/user/{user}', 'UserBandsController@remove')
    ->name('bands.user.remove');

Route::post('/bands/{band}/user/{user}', 'UserBandsController@add')
    ->name('bands.user.add');

Route::delete('/bands/{band}/user/{user}/role/{bandRole}', 'UserBandsController@removeBandRole')
    ->name('bands.user.role.remove');

Route::post('/bands/{band}/user/{user}/role/{bandRole}', 'UserBandsController@addBandRole')
    ->name('bands.user.role.add');
/*
|--------------------------------------------------------------------------
| Band Roles
|--------------------------------------------------------------------------
*/

Route::get('/band_roles', 'BandRolesController@index')
    ->name('band_roles.index');

Route::post('/band_roles', 'BandRolesController@store')
    ->name('band_roles.store')
    ->middleware('can:create,App\BandRole');

Route::get('/band_roles/{bandRole}', 'BandRolesController@show')
    ->name('band_roles.view')
    ->middleware('can:view,bandRole');

Route::put('/band_roles/{bandRole}', 'BandRolesController@update')
    ->name('band_roles.update')
    ->middleware('can:update,bandRole');

Route::delete('/band_roles/{bandRole}', 'BandRolesController@destroy')
    ->name('band_roles.delete')
    ->middleware('can:delete,bandRole');


Route::delete('/user/{user}/involvement/{bandRole}', 'UserBandRolesController@remove')
    ->name('user.involvement.remove');

Route::post('/user/{user}/involvement/{bandRole}', 'UserBandRolesController@add')
    ->name('user.involvement.add');

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/
Route::put('/users/{user}', 'UsersController@update')
    ->name('users.update')
    ->middleware('can:update,user');

Route::get('/users', 'UsersController@index')
    ->name('users.index');


/*
|--------------------------------------------------------------------------
| Settings
|--------------------------------------------------------------------------
*/
Route::get('/me', 'SettingsController@me')
    ->name('me');

Route::get('/team_settings', 'SettingsController@team')
    ->name('settings.team');
/*
|--------------------------------------------------------------------------
| Team Subscriptions
|--------------------------------------------------------------------------
*/
Route::get('/team_subscriptions', 'TeamSubscriptionsController@index')
    ->name('team_subscriptions.index')
    ->middleware('can:index,App\TeamSubscription');

Route::delete('/team_subscriptions/{teamSubscription}', 'TeamSubscriptionsController@destroy')
    ->name('team_subscriptions.delete')
    ->middleware('can:delete,teamSubscription');

Route::delete('/team_subscriptions/membership/{user}', 'TeamSubscriptionsController@remove')
    ->name('team_subscriptions.membership.remove');

Route::put('/team_subscriptions/change_role/{user}', 'TeamSubscriptionsController@changeRole')
    ->name('team_subscriptions.change_role');

/*
|--------------------------------------------------------------------------
| Teams
|--------------------------------------------------------------------------
*/
Route::get('/teams/leave/{team}', 'TeamsController@leave')
    ->name('teams.leave')
    ->middleware('can:leave,team');
    
Route::get('/teams/activate/{team}', 'TeamsController@activate')
    ->name('teams.activate')
    ->middleware('can:activate,team');

Route::post('/teams', 'TeamsController@store')
    ->name('teams.store');

/*
|--------------------------------------------------------------------------
| Invite links
|--------------------------------------------------------------------------
*/
Route::post('/invite/{team}', 'InviteLinksController@invite')
    ->name('invite')
    ->middleware('can:invite,team');

Route::get('/invite/{team}/{email}/{token}', 'InviteLinksController@accept')
    ->name('invite.accept');
Route::post('/invite/{team}/{email}/{token}', 'InviteLinksController@acceptConfirm')
    ->name('invite.accept.confirm');

/*
|--------------------------------------------------------------------------
| Services
|--------------------------------------------------------------------------
*/

Route::get('/services', 'ServicesController@index')
    ->name('services.index');

Route::post('/services', 'ServicesController@store')
    ->name('services.store')
    ->middleware('can:create,App\Service');

Route::get('/services/{service}', 'ServicesController@show')
    ->name('services.view')
    ->middleware('can:view,service');

Route::put('/services/{service}', 'ServicesController@update')
    ->name('services.update')
    ->middleware('can:update,service');

Route::delete('/services/{service}', 'ServicesController@destroy')
    ->name('services.delete')
    ->middleware('can:delete,service');


/*
|--------------------------------------------------------------------------
| Authors
|--------------------------------------------------------------------------
*/

Route::get('/authors', 'AuthorsController@index')
    ->name('authors.index');

Route::post('/authors', 'AuthorsController@store')
    ->name('authors.store')
    ->middleware('can:create,App\Author');

Route::get('/authors/{author}', 'AuthorsController@show')
    ->name('authors.view')
    ->middleware('can:view,author');

Route::put('/authors/{author}', 'AuthorsController@update')
    ->name('authors.update')
    ->middleware('can:update,author');

Route::delete('/authors/{author}', 'AuthorsController@destroy')
    ->name('authors.delete')
    ->middleware('can:delete,author');


/*
|--------------------------------------------------------------------------
| Export
|--------------------------------------------------------------------------
*/
Route::get('/export/open_song/set/{set}', 'ExportsController@openSongSet')
    ->name('export.opensong.set');

Route::post('/export/open_song/songs', 'ExportsController@openSongSongs')
    ->name('export.opensong.songs');




 