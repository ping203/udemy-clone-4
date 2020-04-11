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

Auth::routes();

//Route::get('/', function () {
//    return view('home');
//});

//コース一覧
Route::get('/', 'CourseController@index')->name('courses.index');

Route::get('/courses/{course}', 'CourseController@show')->name('courses.show');

//カテゴリ別コース一覧
Route::get('category/{category}', 'CategoryController@show')->name('categories.show');

//cartに追加
Route::post('/addCart', 'CartController@addCart')->name('addCart');
Route::get('/carts', 'CartController@index')->name('carts.index');
