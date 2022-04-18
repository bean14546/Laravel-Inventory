<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'user_id'
    ];
    // Product relationship (Join table) 1 psroduct ถูกเพิ่มได้จาก user 1 คน
    public function user(){
        return $this->belongsTo(User::class);
    }
}
