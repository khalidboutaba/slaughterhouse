<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Animal;


class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'note'];

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}

