<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    // اضافه کردن یک ویژگی مجازی به مدل برای بررسی وضعیت تخفیف
    protected $append = ['is_sale'];

    /**
     * بررسی وضعیت تخفیف محصول
     * این متد یک ویژگی محاسبه‌شده به نام is_sale ایجاد می‌کند که بررسی می‌کند آیا تخفیف فعال است یا خیر.
     *
     * @return bool
     */
    public function getIsSaleAttribute()
    {
        $isSale = $this->sale_price > 0 
            && $this->date_on_sale_from < Carbon::now() 
            && $this->date_on_sale_to > Carbon::now();
        return $isSale;
    }

    /**
     * ارتباط با تصاویر محصول
     * این متد مشخص می‌کند که هر محصول می‌تواند دارای چندین تصویر باشد.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * ایجاد کوئری برای جستجو در محصولات
     * این اسکوپ  محصولات را براساس نام یا توضیحات جستجوی می‌کند.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search واژه جستجو
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', '%' . trim($search) . '%')->orWhere('description', 'LIKE', '%' . trim($search) . '%');
    }
}
