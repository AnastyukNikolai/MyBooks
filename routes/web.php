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

Route::get('/find', 'SearchController@find')->name('search');

Route::get('/', 'IndexController@indexShow');

Route::get('/q/{table}/{id}/{sort_param}/{search?}', 'IndexController@indexShow')->name('filterAndSort');

//Route::get('/{artworksS_id?}', 'IndexController@indexShow')->name('artworksS');

Route::get('/user/{id}/books', 'authorController@artworksShow')->name('artworksShow');



Route::get('/chapter/{id}', 'IndexController@chapterShow')->name('chapterShow');

Route::get('/test', 'readerController@test')->name('test');
Route::get('/artwork/{id}/reviews', 'ReviewController@show')->name('reviewsShow');

////////////////////////////////////////////Author
Route::group(['middleware' => 'auth'], function() {

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

    Route::get('/chapter/{id}/{anons}/finance', 'authorController@showChapterFinance')->name('chapterFinancialOperations');



////////////////////////////////////////////User





Route::get('/user/{id}/profile', 'UserController@show')->name('showUser');
Route::get('/artwork/{id}/review/add', 'readerController@addReview')->name('addReview');
Route::post('/artwork/review/add', 'readerController@storeReview')->name('storeReview');
Route::get('/artwork/{id}/review/edit', 'readerController@editReview')->name('editReview');
Route::post('/artwork/review/edit', 'readerController@updateReview')->name('updateReview');
Route::get('/review/{id}/delete', 'readerController@deleteReview')->name('deleteReview');

Route::get('/user/{id}/favorites', 'FavoriteController@show')->name('favoritesShow');
Route::get('/artwork/{artwork_id}/AddToFavorites/user/{user_id}', 'FavoriteController@add')->name('addToFavorite');
Route::get('/artwork/{artwork_id}/DeleteFromFavorites/user/{user_id}', 'FavoriteController@delete')->name('deleteFromFavorites');

Route::get('/user/{id}/liked', 'UserController@likedShow')->name('likedShow');
Route::get('/artwork/{id}/like/add', 'readerController@addLike')->name('addLike');
Route::get('/{artwork_id}/{user_id}/like/delete', 'readerController@deleteLike')->name('deleteLike');

Route::get('/user/{id}/messages/{type?}', 'MessageController@indexShow')->name('messagesIndex');
Route::get('/message/{id}', 'MessageController@show')->name('showMessage');
Route::get('/user/{id}/message/add', 'MessageController@add')->name('addMessage');
Route::post('/user/{id?}/message/store', 'MessageController@store')->name('storeMessage');

Route::get('/chapter/{id}/buy', 'FinancialController@chapterBuy')->name('chapterBuy');
Route::post('/chapter/sponsorship', 'FinancialController@chapterSponsorship')->name('chapterSponsorship');
Route::get('/chapter/{id}/cancel/sponsorship', 'readerController@cancelSponsorship')->name('cancelSponsorship');

Route::get('/user/{id}/finance', 'authorController@showUserFinance')->name('userFinancialOperations');

Route::get('balance/up', 'MessageController@upBalance')->name('upBalance');

Route::post('balance/up/store', 'MessageController@upBalanceStore')->name('userBalanceUp');

Route::post('balance/update', 'FinancialController@updateBalance')->name('updateBalance');

});

////////////////////////////////////////////

Route::auth();

Route::get('/book/{id}', 'IndexController@bookShow')->name('bookShow');

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





Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
