<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role_id', 
    ];

    public $timestamps = false; 

    protected $hidden = [
        'password',
    ];
    
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    // RELASI
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function hasRole($roleName)
    {
        if (is_array($roleName)) {
            // Jika roleName adalah array (misal: ['admin', 'superadmin'])
            return $this->role && in_array($this->role->name, $roleName);
        }

        // Jika roleName adalah string (misal: 'superadmin')
        return $this->role && $this->role->name == $roleName;
    }
}