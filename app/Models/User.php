<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['name','email','password','role'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['password' => 'hashed'];
    public function transactions() { return $this->hasMany(ItemTransaction::class, 'created_by'); }
    public function auditLogs() { return $this->hasMany(AuditLog::class); }
    public function isSuperAdmin(): bool { return $this->role === 'superadmin'; }
}