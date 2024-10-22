<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\SalesPayment;



class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'note'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function payments()
    {
        // Retrieve payments through sales
        return $this->hasManyThrough(SalesPayment::class, Sale::class, 'customer_id', 'sale_id');
    }
}
