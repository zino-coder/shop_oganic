<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'parent_id',
    ];

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
}
