<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'client_img',
        'client_name',
        'product_id',
    ];
    

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
