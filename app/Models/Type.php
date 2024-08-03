<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public function subtypes() {
        return $this->hasMany(Subtype::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function sizes() {
        return $this->hasMany(Size::class);
    }
}
