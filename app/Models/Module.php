<?php

namespace App\Models;

use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
  use HasFactory, SoftDeletes;

  protected $primaryKey = 'code';
  public $incrementing = false;

  protected $fillable = ['code', 'name', 'description', 'parent_code', 'is_active'];

  public function permissions()
  {
    return $this->belongsToMany(Permission::class, 'permission_modules');
  }

  public function submodules()
  {
    return $this->hasMany(Module::class, 'parent_code', 'code');
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