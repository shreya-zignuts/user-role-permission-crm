<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

$controller_path = 'App\Http\Controllers';

// Main Page Route
Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
Route::post('/auth/login-basic', $controller_path . '\authentications\LoginBasic@login')->name('login');

Route::middleware('auth')->group(function () use ($controller_path) {
  Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-home');

  Route::get('/page-2', $controller_path . '\pages\Page2@index')->name('pages-page-2');

  // pages
  Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');

  Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name(
    'auth-register-basic'
  );

  Route::get('/modules', $controller_path . '\ModuleController@index')->name('pages-modules');

  Route::get('/edit/{moduleId}', $controller_path . '\ModuleController@edit')->name('edit-module');
  Route::post('/update/{moduleId}', $controller_path . '\ModuleController@update')->name('update-module');

  Route::get('/permissions', $controller_path . '\PermissionController@index')->name('pages-permissions');
});
