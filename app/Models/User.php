<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\Token;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'password',
    'phone_number',
    'address',
    'password',
    'is_active',
    'invitation_token',
    'status',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = ['password', 'remember_token'];

  public function getRememberTokenName()
  {
    return 'remember_token';
  }
  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function roles()
  {
    return $this->belongsToMany(Role::class, 'user_roles');
  }

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function updatedBy()
  {
    return $this->belongsTo(User::class, 'updated_by');
  }

  // public function getModulesWithPermissions()
  // {
  //   $modules = collect();
  //   foreach ($this->roles as $role) {
  //     foreach ($role->permissions as $permission) {
  //       $modules = $modules->merge(
  //         $permission->modules->filter(function ($module) {
  //           return $module->pivot->add_access ||
  //             $module->pivot->view_access ||
  //             $module->pivot->edit_access ||
  //             $module->pivot->delete_access;
  //         })
  //       );
  //     }
  //   }

  //   return $modules->unique('code');
  // }

  public function getModulesWithPermissions()
  {
    $modules = collect();

    foreach ($this->roles as $role) {
      foreach ($role->permissions as $permission) {
        // Get modules associated with the permission
        $permissionModules = $permission->modules->filter(function ($module) use ($permission) {
          return $module->pivot->add_access ||
            $module->pivot->view_access ||
            $module->pivot->edit_access ||
            $module->pivot->delete_access;
        });

        // Merge the filtered modules with the main modules collection
        $modules = $modules->merge($permissionModules);
      }
    }

    // Ensure unique modules based on code
    return $modules->unique('code');
  }

  // public function getModulesWithPermissions()
  // {
  //   $modules = collect();

  //   foreach ($this->roles as $role) {
  //     foreach ($role->permissions as $permission) {
  //       // Retrieve modules and submodules with permissions
  //       $modules = $modules->merge(
  //         $permission
  //           ->modules()
  //           ->with([
  //             'submodules' => function ($query) use ($permission) {
  //               $query->whereHas('permissions', function ($subQuery) use ($permission) {
  //                 $subQuery->where('permission_id', $permission->id)->where(function ($q) {
  //                   $q->where('add_access', 1)
  //                     ->orWhere('view_access', 1)
  //                     ->orWhere('edit_access', 1)
  //                     ->orWhere('delete_access', 1);
  //                 });
  //               });
  //             },
  //           ])
  //           ->get()
  //       );
  //     }
  //   }

  //   // Return unique modules with permitted submodules
  //   return $modules->unique('code');
  // }

  public static function getModulePermissions($user, $moduleCode)
  {
    $module = Module::where('code', $moduleCode)->first();
    if (!$module) {
      return null;
    }

    $permissions = $module
      ->permissions()
      ->withPivot('view_access', 'add_access', 'edit_access', 'delete_access')
      ->get();

    return [
      'view' => $permissions->where('pivot.view_access', true)->isNotEmpty(),
      'add' => $permissions->where('pivot.add_access', true)->isNotEmpty(),
      'edit' => $permissions->where('pivot.edit_access', true)->isNotEmpty(),
      'delete' => $permissions->where('pivot.delete_access', true)->isNotEmpty(),
    ];
  }
}
