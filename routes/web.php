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

// Route::prefix('forgotpassword')->group(function () use ($controller_path) {
//   Route::get('/form', $controller_path . '\UserController@showForgotForm')->name('forgot-password-form');
//   Route::post('/update', $controller_path . '\UserController@sendResetLinkEmail')->name('send-mail');
// });

Route::prefix('password')->group(function () use ($controller_path) {
  Route::get('/reset', $controller_path . '\admin\UserController@showResetForm')->name('password.reset');
  Route::post('/reset', $controller_path . '\admin\UserController@resetPassword')->name('password.update');
});

Route::prefix('forgotpassword')->group(function () use ($controller_path) {
  Route::get('/form', $controller_path . '\authentications\ForgotPasswordController@showForgotForm')->name(
    'forgot-password-form'
  );
  Route::post('/update', $controller_path . '\authentications\ForgotPasswordController@sendResetLinkEmail')->name(
    'send-mail'
  );
  Route::get('/reset', $controller_path . '\authentications\ForgotPasswordController@showResetForm')->name(
    'reset.password.form'
  );
  Route::post('/reset', $controller_path . '\authentications\ForgotPasswordController@resetPassword')->name(
    'forgot.password.reset'
  );
});

Route::middleware(['auth', 'permission', 'admin.check'])
  ->prefix('admin')
  ->group(function () use ($controller_path) {
    // Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name(
    //   'auth-register-basic'
    // );

    Route::get('/', $controller_path . '\admin\AdminController@index')->name('pages-home');

    Route::prefix('modules')->group(function () use ($controller_path) {
      Route::get('/', $controller_path . '\admin\ModuleController@index')->name('pages-modules');
      Route::get('/edit/{moduleId}', $controller_path . '\admin\ModuleController@edit')->name('edit-module');
      Route::post('/update/{moduleId}', $controller_path . '\admin\ModuleController@update')->name('update-module');
      Route::get('/change-status/{moduleId}', $controller_path . '\admin\ModuleController@toggleModuleStatus')->name(
        'module-status'
      );
    });

    Route::prefix('permissions')->group(function () use ($controller_path) {
      Route::get('/', $controller_path . '\admin\PermissionController@index')->name('pages-permissions');
      Route::get('/create', $controller_path . '\admin\PermissionController@create')->name('create-permission');
      Route::post('/store', $controller_path . '\admin\\PermissionController@store')->name('store-permission');
      Route::get('/change-status/{id}', $controller_path . '\admin\PermissionController@togglePermissionStatus')->name(
        'per-status'
      );
      Route::get('/edit/{id}', $controller_path . '\admin\PermissionController@edit')->name('edit-permission');
      Route::post('/update/{id}', $controller_path . '\admin\PermissionController@update')->name('update-permission');
      Route::post('/delete/{id}', $controller_path . '\admin\PermissionController@delete')->name('delete-permission');
    });

    Route::prefix('roles')->group(function () use ($controller_path) {
      Route::get('/', $controller_path . '\admin\RoleController@index')->name('pages-roles');
      Route::get('/create', $controller_path . '\admin\RoleController@create')->name('create-role');
      Route::post('/store', $controller_path . '\admin\RoleController@store')->name('store-role');
      Route::get('/change-status/{id}', $controller_path . '\admin\RoleController@toggleRoleStatus')->name(
        'role-status'
      );
      Route::get('/edit/{id}', $controller_path . '\admin\RoleController@edit')->name('edit-role');
      Route::post('/update/{id}', $controller_path . '\admin\RoleController@update')->name('update-role');
      Route::post('/delete/{id}', $controller_path . '\admin\RoleController@delete')->name('delete-role');
    });

    Route::prefix('users')->group(function () use ($controller_path) {
      Route::get('/', $controller_path . '\admin\UserController@index')->name('pages-users');
      Route::get('/create', $controller_path . '\admin\UserController@create')->name('create-user');
      Route::post('/store', $controller_path . '\admin\UserController@store')->name('store-user');
      Route::get('/change-status/{id}', $controller_path . '\admin\UserController@toggleStatus')->name('user-status');
      Route::get('/edit/{id}', $controller_path . '\admin\UserController@edit')->name('edit-user');
      Route::post('/update/{id}', $controller_path . '\admin\UserController@update')->name('update-user');
      Route::post('/delete/{id}', $controller_path . '\admin\UserController@delete')->name('delete-user');

      Route::post('/reset-password', $controller_path . '\admin\UserController@resetPasswordForm')->name(
        'reset-password'
      );

      Route::post('/logout-user/{id}', $controller_path . '\admin\UserController@forceLogoutUser')->name('logout.user');
    });
  });

Route::middleware(['auth', 'user.check'])->group(function () use ($controller_path) {
  Route::prefix('userside')->group(function () use ($controller_path) {
    Route::get('/', $controller_path . '\user\UserSideController@index')->name('pages-userside');
    Route::get('/users-modules', $controller_path . '\user\UserSideController@showModules')->name('users-modules');
    Route::get('/edit/{id}', $controller_path . '\user\UserSideController@edit')->name('edit-user-profile');
    Route::post('/update/{id}', $controller_path . '\user\UserSideController@update')->name('update-user-profile');
    Route::post('/reset-password', $controller_path . '\user\UserSideController@resetPassword')->name(
      'user-reset-password'
    );

    Route::prefix('modules')->group(function () use ($controller_path) {
      Route::prefix('/people')->group(function () use ($controller_path) {
        Route::get('/', $controller_path . '\user\PeopleController@index')
          ->name('userside-people')
          ->middleware('check.access:PPL,view');
        Route::get('/create', $controller_path . '\user\PeopleController@create')
          ->name('create-people')
          ->middleware('check.access:PPL,add');
        Route::post('/store', $controller_path . '\user\PeopleController@store')->name('store-people');
        Route::get('/edit/{id}', $controller_path . '\user\PeopleController@edit')
          ->name('edit-people')
          ->middleware('check.access:PPL,edit');
        Route::post('/update/{id}', $controller_path . '\user\PeopleController@update')->name('update-people');
        Route::post('/delete/{id}', $controller_path . '\user\PeopleController@delete')
          ->name('delete-people')
          ->middleware('check.access:PPL,delete');
        Route::get('/change-status/{id}', $controller_path . '\user\PeopleController@toggleStatus')->name(
          'people-status'
        );
      });

      Route::prefix('/activityLogs')->group(function () use ($controller_path) {
        Route::get('/', $controller_path . '\user\ActivityLogController@index')
          ->name('userside-activityLogs')
          ->middleware('check.access:ACT,view');
        Route::get('/create', $controller_path . '\user\ActivityLogController@create')
          ->name('create-activityLogs')
          ->middleware('check.access:ACT,add');
        Route::post('/store', $controller_path . '\user\ActivityLogController@store')->name('store-activityLogs');
        Route::get('/edit/{id}', $controller_path . '\user\ActivityLogController@edit')
          ->name('edit-activityLogs')
          ->middleware('check.access:ACT,edit');
        Route::post('/update/{id}', $controller_path . '\user\ActivityLogController@update')->name(
          'update-activityLogs'
        );
        Route::post('/delete/{id}', $controller_path . '\user\ActivityLogController@delete')
          ->name('delete-activityLogs')
          ->middleware('check.access:ACT,delete');
        Route::get('/change-status/{id}', $controller_path . '\user\ActivityLogController@toggleStatus')->name(
          'activityLogs-status'
        );
      });

      Route::prefix('/notes')->group(function () use ($controller_path) {
        Route::get('/', $controller_path . '\user\NotesController@index')
          ->name('userside-notes')
          ->middleware('check.access:NTS,view');
        Route::get('/create', $controller_path . '\user\NotesController@create')
          ->name('create-notes')
          ->middleware('check.access:NTS,add');
        Route::post('/store', $controller_path . '\user\NotesController@store')->name('store-notes');
        Route::get('/edit/{id}', $controller_path . '\user\NotesController@edit')
          ->name('edit-notes')
          ->middleware('check.access:NTS,edit');
        Route::post('/update/{id}', $controller_path . '\user\NotesController@update')->name('update-notes');
        Route::post('/delete/{id}', $controller_path . '\user\NotesController@delete')
          ->name('delete-notes')
          ->middleware('check.access:NTS,delete');
      });

      Route::prefix('/meeting')->group(function () use ($controller_path) {
        Route::get('/', $controller_path . '\user\MeetingController@index')
          ->name('userside-meetings')
          ->middleware('check.access:MET,view');
        Route::get('/create', $controller_path . '\user\MeetingController@create')
          ->name('create-meetings')
          ->middleware('check.access:MET,add');
        Route::post('/store', $controller_path . '\user\MeetingController@store')->name('store-meetings');
        Route::get('/edit/{id}', $controller_path . '\user\MeetingController@edit')
          ->name('edit-meetings')
          ->middleware('check.access:MET,edit');
        Route::post('/update/{id}', $controller_path . '\user\MeetingController@update')->name('update-meetings');
        Route::post('/delete/{id}', $controller_path . '\user\MeetingController@delete')
          ->name('delete-meetings')
          ->middleware('check.access:MET,delete');
        Route::get('/change-status/{id}', $controller_path . '\user\MeetingController@toggleStatus')->name(
          'meetings-status'
        );
      });

      Route::prefix('/company')->group(function () use ($controller_path) {
        Route::get('/', $controller_path . '\user\CompanyController@index')
          ->name('userside-company')
          ->middleware('check.access:CMP,view');
        Route::get('/create', $controller_path . '\user\CompanyController@create')
          ->name('create-company')
          ->middleware('check.access:CMP,add');
        Route::post('/store', $controller_path . '\user\CompanyController@store')->name('store-company');
        Route::get('/edit/{id}', $controller_path . '\user\CompanyController@edit')
          ->name('edit-company')
          ->middleware('check.access:CMP,edit');
        Route::post('/update/{id}', $controller_path . '\user\CompanyController@update')->name('update-company');
        Route::post('/delete/{id}', $controller_path . '\user\CompanyController@delete')
          ->name('delete-company')
          ->middleware('check.access:CMP,delete');
      });
    });
  });
});
