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

  // Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name(
  //   'auth-register-basic'
  // );

  Route::prefix('modules')->group(function () use ($controller_path) {
    Route::get('/', $controller_path . '\ModuleController@index')->name('pages-modules');
    Route::get('/edit/{moduleId}', $controller_path . '\ModuleController@edit')->name('edit-module');
    Route::post('/update/{moduleId}', $controller_path . '\ModuleController@update')->name('update-module');
  });

  Route::prefix('permissions')->group(function () use ($controller_path) {
    Route::get('/', $controller_path . '\PermissionController@index')->name('pages-permissions');
    Route::get('/create', $controller_path . '\PermissionController@create')->name('create-permission');
    Route::post('/store', $controller_path . '\PermissionController@store')->name('store-permission');
    Route::get('/edit/{id}', $controller_path . '\PermissionController@edit')->name('edit-permission');
    Route::post('/update/{id}', $controller_path . '\PermissionController@update')->name('update-permission');
    Route::post('/delete/{id}', $controller_path . '\PermissionController@delete')->name('delete-permission');
  });

  Route::prefix('roles')->group(function () use ($controller_path) {
    Route::get('/', $controller_path . '\RoleController@index')->name('pages-roles');
    Route::get('/create', $controller_path . '\RoleController@create')->name('create-role');
    Route::post('/store', $controller_path . '\RoleController@store')->name('store-role');
    Route::post('/toggle-status', $controller_path . '\RoleController@toggleStatus')->name('toggle.status');
    Route::get('/edit/{id}', $controller_path . '\RoleController@edit')->name('edit-role');
    Route::post('/update/{id}', $controller_path . '\RoleController@update')->name('update-role');
    Route::post('/delete/{id}', $controller_path . '\RoleController@delete')->name('delete-role');
  });
});
