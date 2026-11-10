<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'customer_id',
        'cashier_id',
        'total_berat',
        'subtotal',
        'diskon',
        'total_bayar',
        'status_pembayaran',
        'status_laundry',
        'tanggal_masuk',
        'tanggal_selesai'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function laundryStatuses()
    {
        return $this->hasMany(LaundryStatus::class);
    }
}
