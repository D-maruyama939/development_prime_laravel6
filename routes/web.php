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

// ログイン
Auth::routes();

// トップページ
Route::get('/', 'UserController@toppage')->name('top');
// いいね追加・削除処理
Route::patch('/likes/{item}/toggle_like', 'LikeController@toggleLike')->name('likes.toggle_like');

// プロフィール詳細画面
Route::resource('users','UserController')->only([
    'show',
]);
// プロフィール編集画面
Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
// プロフィール更新処理
Route::patch('/profile', 'ProfileController@update')->name('profile.update');
// プロフィール画像編集画面
Route::get('/profile/edit_image', 'ProfileController@editImage')->name('profile.edit_image');
// プロフィール画像更新処理
Route::patch('/profile/edit_image', 'ProfileController@updateImage')->name('profile.update_image');

// 出品商品一覧
Route::get('users/{user}/exhibitions', 'UserController@exhibitions')->name('users.exhibitions');
// 商品追加（出品）・追加処理・商品情報編集・編集処理・商品詳細
Route::resource('items','ItemController')->only([
    'create','store','edit','update','show','destroy',
]);
// 商品画像編集画面
Route::get('/items/{item}/edit_image', 'ItemController@editItemImage')->name('items.edit_image');
// 商品画像更新処理
Route::patch('items/{item}/edit_image', 'ItemController@updateItemImage')->name('items.update_image');

// 購入確認画面
Route::get('items/{item}/confirm', 'ItemController@confirm')->name('items.confirm');
// 購入処理
Route::get('items/{item}/buy', 'ItemController@buy')->name('items.buy');
// 購入完了画面
Route::get('items/{item}/finish', 'ItemController@finish')->name('items.finish');

// お気に入り一覧
Route::get('likes','LikeController@index')->name('likes.index');
