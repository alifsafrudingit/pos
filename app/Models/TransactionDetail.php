<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transaction_details';
    protected $guarded = [];
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
