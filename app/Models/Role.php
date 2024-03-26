<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
  use HasFactory, SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'description'];

  /**
   * The users that belong to the role.
   */
  public function users()
  {
    return $this->belongsToMany(User::class, 'user_roles');
  }

  /**
   * The permissions that belong to the role.
   */
  public function permissions()
  {
    return $this->belongsToMany(Permission::class, 'role_permissions');
  }

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function updatedBy()
  {
    return $this->belongsTo(User::class, 'updated_by');
  }
}