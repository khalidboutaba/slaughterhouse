<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Animal;
use App\Models\Component;
use App\Models\SalesPayment;



class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'animal_id',
        'total_price',
        'sale_date',
        'note',
        'quantity',
        'weight',
        'components',
        'price_per_kg',
        'total_paid',
        'final_price',
        'sale_status',
    ];

    protected $casts = [
        'components' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function payments()
    {
        return $this->hasMany(SalesPayment::class);
    }

    public function updateSaleStatus()
    {
        if ($this->total_paid >= $this->final_price) {
            $this->sale_status = 'paid';
        } elseif ($this->total_paid > 0 && $this->total_paid < $this->final_price) {
            $this->sale_status = 'partially_paid';
        } else {
            $this->sale_status = 'not_paid';
        }

        $this->save();
    }

}
