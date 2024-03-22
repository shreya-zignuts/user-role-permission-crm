<?php

namespace App\Models;

use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = ['name', 'description', 'is_active'];

  public function modules()
  {
    return $this->belongsToMany(Module::class, 'permission_modules');
  }

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function updatedBy()
  {
    return $this->belongsTo(User::class, 'updated_by');
  }

  /**
   * Check if the permission has a specific access.
   *
   * @param string $moduleCode
   * @param string $accessType
   * @return bool
   */
  public function hasAccess(string $moduleCode, string $accessType): bool
  {
    $accessColumnName = $accessType . '_access';
    return $this->modules()
      ->where('module_code', $moduleCode)
      ->value($accessColumnName) == 1;
  }
}