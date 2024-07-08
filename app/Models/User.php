<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model {
    use HasFactory;

    protected $fillable = ['username', 'phonenumber', 'unique_link', 'link_expires_at', 'active'];
}
