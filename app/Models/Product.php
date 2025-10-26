<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'category', 'image', 'stock_quantity', 'is_active'];

    //Category relation 
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //Comments relation (Polymorphic relation)
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
