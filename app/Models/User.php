<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_KASIR = 'kasir';
    public const ROLE_PELANGGAN = 'pelanggan';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Pelanggan
    public function customerTransactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id');
    }

    // Kasir
    public function cashierTransactions()
    {
        return $this->hasMany(Transaction::class, 'cashier_id');
    }

    // Update Status Laundry
    public function laundryStatuses()
    {
        return $this->hasMany(LaundryStatus::class, 'updated_by');
    }
}
