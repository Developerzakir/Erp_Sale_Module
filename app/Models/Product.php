<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function saleItems() {
        return $this->hasMany(SaleItem::class);
    }

    public function notes() {
        return $this->morphMany(Note::class, 'noteable');
    }
}
