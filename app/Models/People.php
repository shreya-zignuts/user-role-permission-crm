<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class People extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'peoples';

  protected $fillable = ['name', 'designation', 'email', 'phone_number', 'address', 'is_active', 'user_id'];

  public function user()
  {
    return $this->belongsTo(User::class);
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