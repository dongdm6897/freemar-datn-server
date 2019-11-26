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
/*Auth::routes(['verify' => true]);*/


Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');


Route::get('/category', function () {
    return view('category');
});



Route::get('/demo', function () {
    return view('demo');
});
Route::get('/list', function () {
    return view('list');
});
Route::get('/blank', function () {
    return view('blank');
});


Auth::routes();

Route::get('/home', 'Admin\HomeController@index')->name('home');

