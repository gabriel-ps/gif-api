<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->namespace('Auth')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::prefix('gifs')->middleware('auth')->group(function () {
    Route::get('/', 'GifsController@index');

    Route::get('/favorites', 'GifFavoritesController@index');
    Route::post('/favorites', 'GifFavoritesController@store');
    Route::delete('/favorites/{id}', 'GifFavoritesController@destroy');

    Route::get('/searches', 'GifSearchesController@index');
});
