<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'quantity',
        // Add other fillable fields as needed
    ];

    // Define relationships or other methods here

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
