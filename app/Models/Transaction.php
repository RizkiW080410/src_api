<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $connection = 'mysql';
    protected $fillable = ['product_id', 'total_transaction'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
