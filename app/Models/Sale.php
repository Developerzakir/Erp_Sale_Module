<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory,SoftDeletes;

  

    protected $fillable = ['user_id', 'date', 'total'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(SaleItem::class);
    }

    public function notes() {
        return $this->morphMany(Note::class, 'noteable');
    }

    // Accessor
    public function getFormattedTotalAttribute() {
        return number_format($this->total, 2) . ' BDT';
    }
}
