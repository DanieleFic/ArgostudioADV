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

Route::get('/', function () {
    return view('welcome');
});



//Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')
    ->namespace('Admin') //namespace Admin dice che tutte le rotte vanno prese nel controller nella cartella Admin
    ->name('admin.') //tutte le rotte avranno all inizio admin.
    ->prefix('admin') //relativo a tutto le rotte (prefisso della url)
    ->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('/user', 'UserController');/* ->except(['edit', 'update']); */
        Route::resource('/user/{user:id}/messages', 'MessagesController');

    });

    Auth::routes();
