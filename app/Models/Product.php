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
        'stock',
        'price',
        'sale_price',
        'description',
        'content',
        'category_id',
        'is_active',
        'is_hot',
        'is_featured',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function thumbnail()
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'thumbnail');
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'mediable')->where('type', 'images');
    }
}
