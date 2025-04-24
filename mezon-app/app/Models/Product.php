<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $append = ['is_sale'];

    public function getIsSaleAttribute()
    {
        $isSale = $this->sale_price > 0 && $this->date_on_sale_from < Carbon::now() && $this->date_on_sale_to > Carbon::now();
        return $isSale;
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }
}
