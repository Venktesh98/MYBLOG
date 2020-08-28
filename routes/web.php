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



Route::get('/','BlogController@index')->name('blog');

Route::get('/blog/{postid}', 'BlogController@show')->name('blog.showblog');

Route::get('/category/{category}','BlogController@category')->name('blog.category');

Route::get('/author/{author}','BlogController@author')->name('blog.author');
Route::get('/tag/{tag}','BlogController@tag');


Auth::routes();

Route::get('/home', 'Backend\HomeController@index');
Route::get('/edit-profile' ,'Backend\HomeController@edit');
Route::put('/edit-profile' ,'Backend\HomeController@update');

Route::resource('/backend/blog','Backend\BlogController');

Route::resource('/backend/categories','Backend\CategoriesController');

Route::resource('/backend/users','Backend\UsersController');

Route::get('/backend/users/confirm/{users}','Backend\UsersController@confirm')->name('users.confirm');

Route::put('backend/blog/restore/{blog}','Backend\BlogController@restore')->name('backend.blog.restore');

Route::delete('backend/blog/force-destroy/{blog}','Backend\BlogController@forceDestroy')->name('backend.blog.force-destroy');


