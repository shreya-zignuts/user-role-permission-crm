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
Route::get('/', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
Route::post('/auth/login-basic', $controller_path . '\authentications\LoginBasic@login')->name('login');
Route::post('/logout', $controller_path . '\authentications\LoginBasic@logout')->name('logout');

Route::get('/password/reset', $controller_path . '\UserController@showResetForm')->name('password.reset');
Route::post('/password/reset', $controller_path . '\UserController@resetPassword')->name('password.update');

Route::prefix('forgotpassword')->group(function () use ($controller_path) {
  Route::get('/form', $controller_path . '\UserController@showForgotForm')->name('forgot-password-form');
  Route::post('/update', $controller_path . '\UserController@sendResetLinkEmail')->name('send-mail');
});

Route::middleware(['auth', 'permission', 'admin.check'])
  ->prefix('admin')
  ->group(function () use ($controller_path) {
    // Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name(
    //   'auth-register-basic'
    // );

    Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-home');

    Route::prefix('modules')->group(function () use ($controller_path) {
      Route::get('/', $controller_path . '\ModuleController@index')->name('pages-modules');
      Route::get('/edit/{moduleId}', $controller_path . '\ModuleController@edit')->name('edit-module');
      Route::post('/update/{moduleId}', $controller_path . '\ModuleController@update')->name('update-module');
      Route::get('/change-status/{moduleId}', $controller_path . '\ModuleController@toggleModuleStatus')->name(
        'module-status'
      );
    });

    Route::prefix('permissions')->group(function () use ($controller_path) {
      Route::get('/', $controller_path . '\PermissionController@index')->name('pages-permissions');
      Route::get('/create', $controller_path . '\PermissionController@create')->name('create-permission');
      Route::post('/store', $controller_path . '\PermissionController@store')->name('store-permission');
      Route::get('/change-status/{id}', $controller_path . '\PermissionController@togglePermissionStatus')->name(
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
      Route::get('/change-status/{id}', $controller_path . '\RoleController@toggleRoleStatus')->name('role-status');
      Route::get('/edit/{id}', $controller_path . '\RoleController@edit')->name('edit-role');
      Route::post('/update/{id}', $controller_path . '\RoleController@update')->name('update-role');
      Route::post('/delete/{id}', $controller_path . '\RoleController@delete')->name('delete-role');
    });

    Route::prefix('users')->group(function () use ($controller_path) {
      Route::get('/', $controller_path . '\UserController@index')->name('pages-users');
      Route::get('/create', $controller_path . '\UserController@create')->name('create-user');
      Route::post('/store', $controller_path . '\UserController@store')->name('store-user');
      Route::get('/change-status/{id}', $controller_path . '\UserController@toggleStatus')->name('user-status');
      Route::get('/edit/{id}', $controller_path . '\UserController@edit')->name('edit-user');
      Route::post('/update/{id}', $controller_path . '\UserController@update')->name('update-user');
      Route::post('/delete/{id}', $controller_path . '\UserController@delete')->name('delete-user');

      Route::post('/reset-password', $controller_path . '\UserController@resetPasswordForm')->name('reset-password');

      Route::post('/logout-user/{id}', $controller_path . '\UserController@forceLogoutUser')->name('logout.user');
    });
  });

Route::middleware(['auth'])->group(function () use ($controller_path) {
  Route::prefix('userside')->group(function () use ($controller_path) {
    Route::get('/', $controller_path . '\UserSideController@index')->name('pages-userside');
    Route::get('/users-modules', $controller_path . '\UserSideController@showModules')->name('users-modules');
    Route::get('/edit/{id}', $controller_path . '\UserSideController@edit')->name('edit-user-profile');
    Route::post('/update/{id}', $controller_path . '\UserSideController@update')->name('update-user-profile');
    Route::post('/reset-password', $controller_path . '\UserSideController@resetPassword')->name('user-reset-password');

    Route::prefix('modules/people')->group(function () use ($controller_path) {
      Route::get('/', $controller_path . '\PeopleController@index')->name('userside-people');
      Route::get('/create', $controller_path . '\PeopleController@create')->name('create-people');
      Route::post('/store', $controller_path . '\PeopleController@store')->name('store-people');
      Route::get('/edit/{id}', $controller_path . '\PeopleController@edit')->name('edit-people');
      Route::post('/update/{id}', $controller_path . '\PeopleController@update')->name('update-people');
      Route::post('/delete/{id}', $controller_path . '\PeopleController@delete')->name('delete-people');
      Route::get('/change-status/{id}', $controller_path . '\PeopleController@toggleStatus')->name('people-status');
    });

    Route::prefix('modules/activityLogs')->group(function () use ($controller_path) {
      Route::get('/', $controller_path . '\ActivityLogController@index')->name('userside-activityLogs');
      Route::get('/create', $controller_path . '\ActivityLogController@create')->name('create-activityLogs');
      Route::post('/store', $controller_path . '\ActivityLogController@store')->name('store-activityLogs');
      Route::get('/edit/{id}', $controller_path . '\ActivityLogController@edit')->name('edit-activityLogs');
      Route::post('/update/{id}', $controller_path . '\ActivityLogController@update')->name('update-activityLogs');
      Route::post('/delete/{id}', $controller_path . '\ActivityLogController@delete')->name('delete-activityLogs');
      Route::get('/change-status/{id}', $controller_path . '\ActivityLogController@toggleStatus')->name(
        'activityLogs-status'
      );
    });

    // Route::prefix('modules/activityLogs')->group(function () use ($controller_path) {
    //   Route::get('/', $controller_path . '\ActivityLogController@index')->name('userside-activityLogs');
    //   Route::get('/create', $controller_path . '\ActivityLogController@create')->name('create-activityLogs');
    //   Route::post('/store', $controller_path . '\ActivityLogController@store')->name('store-activityLogs');
    //   Route::get('/edit/{id}', $controller_path . '\ActivityLogController@edit')->name('edit-activityLogs');
    //   Route::post('/update/{id}', $controller_path . '\ActivityLogController@update')->name('update-activityLogs');
    //   Route::post('/delete/{id}', $controller_path . '\ActivityLogController@delete')->name('delete-activityLogs');
    //   Route::get('/change-status/{id}', $controller_path . '\ActivityLogController@toggleStatus')->name(
    //     'activityLogs-status'
    //   );
    // });

    Route::prefix('modules/notes')->group(function () use ($controller_path) {
      Route::get('/', $controller_path . '\NotesController@index')->name('userside-notes');
      Route::get('/create', $controller_path . '\NotesController@create')->name('create-notes');
      Route::post('/store', $controller_path . '\NotesController@store')->name('store-notes');
      Route::get('/edit/{id}', $controller_path . '\NotesController@edit')->name('edit-notes');
      Route::post('/update/{id}', $controller_path . '\NotesController@update')->name('update-notes');
      Route::post('/delete/{id}', $controller_path . '\NotesController@delete')->name('delete-notes');
    });

    Route::prefix('modules/meeting')->group(function () use ($controller_path) {
      Route::get('/', $controller_path . '\MeetingController@index')->name('userside-meetings');
      Route::get('/create', $controller_path . '\MeetingController@create')->name('create-meetings');
      Route::post('/store', $controller_path . '\MeetingController@store')->name('store-meetings');
      Route::get('/edit/{id}', $controller_path . '\MeetingController@edit')->name('edit-meetings');
      Route::post('/update/{id}', $controller_path . '\MeetingController@update')->name('update-meetings');
      Route::post('/delete/{id}', $controller_path . '\MeetingController@delete')->name('delete-meetings');
      Route::post('/change-status/{id}', $controller_path . '\MeetingController@toggleStatus')->name('meetings-status');
    });

    Route::prefix('modules/company')->group(function () use ($controller_path) {
      Route::get('/', $controller_path . '\CompanyController@index')->name('userside-company');
      Route::get('/create', $controller_path . '\CompanyController@create')->name('create-company');
      Route::post('/store', $controller_path . '\CompanyController@store')->name('store-company');
      Route::get('/edit/{id}', $controller_path . '\CompanyController@edit')->name('edit-company');
      Route::post('/update/{id}', $controller_path . '\CompanyController@update')->name('update-company');
      Route::post('/delete/{id}', $controller_path . '\CompanyController@delete')->name('delete-company');
      Route::post('/change-status/{id}', $controller_path . '\CompanyController@toggleStatus')->name('company-status');
    });
  });
});
