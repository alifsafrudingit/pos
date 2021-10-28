<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'invoice_number';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    protected $table = 'transactions';

    public function detail()
    {
        return $this->hasMany(TransactionDetail::class, 'invoice_number');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
