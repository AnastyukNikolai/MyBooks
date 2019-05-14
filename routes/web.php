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

Route::get('/test', 'readerController@test')->name('test');

////////////////////////////////////////////Author  yh


Route::get('/artwork/add', 'authorController@addArtwork')->name('addArtwork');
Route::post('/artwork/add', 'authorController@storeArtwork')->name('storeArtwork');

Route::get('/artwork/{id}/chapter/add', 'authorController@addArtworkChapter')->name('addArtworkChapter');
Route::post('/artwork/chapter/add', 'authorController@storeArtworkChapter')->name('storeArtworkChapter');
Route::get('/chapter/{id}/edit', 'authorController@editChapter')->name('editChapter');
Route::post('/artwork/chapter/edit', 'authorController@updateArtworkChapter')->name('updateArtworkChapter');
Route::get('/chapter/{id}/delete', 'authorController@deleteChapter')->name('deleteChapter');



Route::get('/artwork/{id}/chapter/anons/add', 'authorController@addChapterAnons')->name('addChapterAnons');
Route::post('/artwork/chapter/anons/add', 'authorController@storeChapterAnons')->name('storeChapterAnons');
Route::get('/anons/{id}/delete', 'authorController@deleteAnons')->name('deleteAnons');

Route::get('/artwork/{id}/chapter/edit', 'authorController@editArtworkChapter')->name('editArtworkChapter');
Route::post('/artwork/chapter/edit', 'authorController@updateArtworkChapter')->name('updateArtworkChapter');

Route::get('/transfer/{id}/chapter/add', 'authorController@addChapter')->name('addTransferChapter');
Route::post('/transfer/chapter/add', 'authorController@storeChapter')->name('storeTransferChapter');

////////////////////////////////////////////User

Route::get('/chapter/{id}/buy', 'FinancialController@chapterBuy')->name('chapterBuy');
Route::post('/chapter/sponsorship', 'FinancialController@chapterSponsorship')->name('chapterSponsorship');
Route::get('/chapter/{id}/cancel/sponsorship', 'readerController@cancelSponsorship')->name('cancelSponsorship');



////////////////////////////////////////////

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login/google', 'Auth\LoginController@redirectToGoogleProvider')->name('googleLogin');

Route::get('login/google/callback', 'Auth\LoginController@handleProviderGoogleCallback');

Route::get('/drive', 'DriveController@getDrive'); // retreive folders

Route::get('/drive/upload', 'DriveController@uploadFile'); // File upload form

Route::post('/drive/upload', 'DriveController@uploadFile')->name('googleUploadFile');; // Upload file to Drive from Form

Route::get('/drive/create', 'DriveController@create'); // Upload file to Drive from Storage

Route::get('/drive/delete/{id}', 'DriveController@deleteFile'); // Delete file or folder
