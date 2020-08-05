<?php

if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
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

// Route::get('/',[
//     'uses'=>'BlogController@index',
//     'as' => 'blog'
//     ]);



Route::get('/','BlogController@index');

Route::get('/blog/{postid}', 'BlogController@show')->name('blog.showblog');

Route::get('/category/{category}','BlogController@category')->name('blog.category');

Route::get('/author/{author}','BlogController@author')->name('blog.author');


Auth::routes();

Route::get('/home', 'Backend\HomeController@index');

Route::resource('/backend/blog','Backend\BlogController');

Route::put('backend/blog/restore/{blog}','Backend\BlogController@restore')->name('backend.blog.restore');


