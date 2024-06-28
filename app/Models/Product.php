<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mysql';
    protected $fillable = ['name', 'qty', 'price'];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
