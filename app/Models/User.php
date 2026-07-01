<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role', 'avatar'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function isAdmin() { return $this->role === 'admin'; } 
    public function orders()
{
    return $this->hasMany(Order::class);
}

public function payments()
{
    return $this->hasManyThrough(
        Payment::class,
        Order::class
    );
}
}
