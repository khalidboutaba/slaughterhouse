<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\PurchasePayment;


class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'price_per_kg', // Add this field
        'total_price',  // Add this field
        'weight',
        'available_weight',
        'entrails_price',
        'supplier_id',
        'origin',
        'reference',
        'note',
        'sold_status',
        'total_paid',
        'purchase_status',
    ];

    // Relationships
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function payments()
    {
        return $this->hasMany(PurchasePayment::class);
    }

    public function updatePurchaseStatus()
    {
        if ($this->total_paid >= $this->total_price) {
            $this->purchase_status = 'paid';
        } elseif ($this->total_paid > 0 && $this->total_paid < $this->total_price) {
            $this->purchase_status = 'partially_paid';
        } else {
            $this->purchase_status = 'not_paid';
        }

        $this->save();
    }
    
}
