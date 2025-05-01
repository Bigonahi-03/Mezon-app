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
     * فیلتر کردن محصولات فعال
     * این اسکوپ فقط محصولات فعال را برمی‌گرداند
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query)
    {
        return $query->where('status', 1);
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

    /**
     * فیلتر کردن محصولات براساس دسته بندی
     * این اسکوپ محصولات را براساس دسته بندی جستجوی می‌کند.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategory($query)
    {
        if (request()->has('category')) {
            $category = Category::where('name', slugToStr(request()->category))->get();
            if ($category) {
                $query->whereIn('category_id', $category->pluck('id')->toArray());
            }
        }
        return $query;
    }

    public function scopeSortBy($query)
    {
        if (request()->has('sortBy')) {
            switch (request()->sortBy) {
                case 'max':
                    $query->orderBy('price', 'desc');
                    break;
                case 'min':
                    $query->orderBy('price', 'asc');
                    break;
                case 'bestSellers':
                    $query;
                    // $query->orderBy('sold_count', 'desc');
                    break;
                case 'mostVisited':
                    $query->orderBy('view_count', 'desc');
                    break;
                case 'sale':
                    $query->where('sale_price', '>', 0)
                    ->where('date_on_sale_from', '<', Carbon::now())
                    ->where('date_on_sale_to', '>', Carbon::now());
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }
        return $query;
    }


}
