<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'is_active'];

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'permission_modules')->withPivot('add_access', 'view_access', 'edit_access', 'delete_access');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
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
