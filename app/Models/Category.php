<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Category extends Model
{
    protected $fillable = [
        'name',
        // Add other fillable fields as needed
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
