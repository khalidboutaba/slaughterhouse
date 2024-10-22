<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class PurchasePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'amount',
        'payment_date',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
