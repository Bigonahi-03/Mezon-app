<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['primary_image', 'name', 'slug', 'category_id', 'status', 'price', 'quantity', 'sale_price' ,'date_on_sale_from' ,'date_on_sale_to', 'is_featured', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    

    public function images(){
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function sizes(){
        return $this->belongsToMany(Size::class, 'product_sizes')->withPivot('quantity')->withTimestamps();;
    }
}
