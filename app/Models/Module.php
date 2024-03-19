<?php

namespace App\Models;

use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
  use HasFactory;

  protected $primaryKey = 'code';
  public $incrementing = false;

  public function submodules()
  {
    return $this->hasMany(Module::class, 'parent_code', 'code');
  }
}