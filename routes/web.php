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

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/', 'IndexController@indexShow');

Route::get('/user/{id}/books', 'authorController@artworksShow')->name('artworksShow');

Route::get('/book/{id}', 'IndexController@bookShow')->name('bookShow');

Route::get('/chapter/{id}', 'IndexController@chapterShow')->name('chapterShow');

Route::get('/artwork/download/{chapter?}', 'IndexController@downloadChapter')->name('downloadChapter');

////////////////////////////////////////////author


Route::get('/artwork/add', 'authorController@addArtwork')->name('addArtwork');
Route::post('/artwork/add', 'authorController@storeArtwork')->name('storeArtwork');

Route::get('/artwork/{id}/chapter/add', 'authorController@addArtworkChapter')->name('addArtworkChapter');
Route::post('/artwork/chapter/add', 'authorController@storeArtworkChapter')->name('storeArtworkChapter');

Route::get('/transfer/{id}/chapter/add', 'authorController@addChapter')->name('addTransferChapter');
Route::post('/transfer/chapter/add', 'authorController@storeChapter')->name('storeTransferChapter');

////////////////////////////////////////////

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
