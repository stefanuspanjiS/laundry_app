<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundryStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'status',
        'keterangan',
        'updated_by',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
