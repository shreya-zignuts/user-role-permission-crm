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
Route::post('/logout', $controller_path . '\authentications\LoginBasic@logout')->name('logout');

Route::get('/password/reset', $controller_path . '\UserController@showResetForm')->name('password.reset');
Route::post('/password/reset', $controller_path . '\UserController@resetPassword')->name('password.update');

Route::prefix('forgotpassword')->group(function () use ($controller_path) {
  Route::get('/form', $controller_path . '\UserController@showForgotForm')->name('forgot-password-form');
  Route::post('/update', $controller_path . '\UserController@sendResetLinkEmail')->name('send-mail');
});

Route::middleware('auth', 'permission')->group(function () use ($controller_path) {
  Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-home');

  // Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name(
  //   'auth-register-basic'
  // );

  Route::prefix('modules')->group(function () use ($controller_path) {
    Route::get('/', $controller_path . '\ModuleController@index')->name('pages-modules');
    Route::get('/edit/{moduleId}', $controller_path . '\ModuleController@edit')->name('edit-module');
    Route::post('/update/{moduleId}', $controller_path . '\ModuleController@update')->name('update-module');
    Route::post('/toggle-status', $controller_path . '\ModuleController@toggleModuleStatus')->name('module-status');
  });

  Route::prefix('permissions')->group(function () use ($controller_path) {
    Route::get('/', $controller_path . '\PermissionController@index')->name('pages-permissions');
    Route::get('/create', $controller_path . '\PermissionController@create')->name('create-permission');
    Route::post('/store', $controller_path . '\PermissionController@store')->name('store-permission');
    Route::post('/toggle-status', $controller_path . '\PermissionController@togglePermissionStatus')->name(
      'per-status'
    );
    Route::get('/edit/{id}', $controller_path . '\PermissionController@edit')->name('edit-permission');
    Route::post('/update/{id}', $controller_path . '\PermissionController@update')->name('update-permission');
    Route::post('/delete/{id}', $controller_path . '\PermissionController@delete')->name('delete-permission');
  });

  Route::prefix('roles')->group(function () use ($controller_path) {
    Route::get('/', $controller_path . '\RoleController@index')->name('pages-roles');
    Route::get('/create', $controller_path . '\RoleController@create')->name('create-role');
    Route::post('/store', $controller_path . '\RoleController@store')->name('store-role');
    Route::post('/toggle-status', $controller_path . '\RoleController@toggleRoleStatus')->name('role-status');
    Route::get('/edit/{id}', $controller_path . '\RoleController@edit')->name('edit-role');
    Route::post('/update/{id}', $controller_path . '\RoleController@update')->name('update-role');
    Route::post('/delete/{id}', $controller_path . '\RoleController@delete')->name('delete-role');
  });

  Route::prefix('users')->group(function () use ($controller_path) {
    Route::get('/', $controller_path . '\UserController@index')->name('pages-users');
    Route::get('/create', $controller_path . '\UserController@create')->name('create-user');
    Route::post('/store', $controller_path . '\UserController@store')->name('store-user');
    Route::post('/toggle-status', $controller_path . '\UserController@toggleStatus')->name('toggle-status');
    Route::get('/edit/{id}', $controller_path . '\UserController@edit')->name('edit-user');
    Route::post('/update/{id}', $controller_path . '\UserController@update')->name('update-user');
    Route::post('/delete/{id}', $controller_path . '\UserController@delete')->name('delete-user');

    Route::post('/reset-password', $controller_path . '\UserController@resetPasswordForm')->name('reset-password');

    Route::post('/logout-user/{id}', $controller_path . '\UserController@forceLogoutUser')->name('logout.user');
  });

  Route::prefix('userside')->group(function () use ($controller_path) {
    Route::get('/', $controller_path . '\UserSideController@index')->name('pages-userside');
  });
});
