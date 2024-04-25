<?php

namespace App\Models;

use App\Models\Module;
use Illuminate\Support\Facades\Auth;
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
        return $this->belongsToMany(Permission::class, 'permission_modules')->withPivot('view_access', 'add_access', 'edit_access', 'delete_access');
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

    protected static function booted()
    {
        // Set "created_by" and "updated_by" values when creating a new record
        static::creating(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->created_by = $user->id;
            }
        });

        // Set "updated_by" value when updating an existing record
        static::updating(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->updated_by = $user->id;
            }
        });
    }
}
