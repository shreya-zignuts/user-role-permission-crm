<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
  use HasFactory;

  protected $table = 'peoples';

  protected $fillable = ['name', 'designation', 'email', 'phone_number', 'address', 'is_active', 'user_id'];
}
