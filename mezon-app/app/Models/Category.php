<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';

    /**
     * دسته‌بندی والد را مشخص می‌کند
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * دسته‌بندی‌های فرزند را مشخص می‌کند
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * تبدیل نام دسته‌بندی به اسلاگ
     *
     * @return string
     */
    public function getSlugAttribute(): string
    {
        return str_replace(' ', '-', $this->name);
    }

    /**
     * فیلتر کردن دسته‌بندی‌های فعال
     * این اسکوپ فقط دسته‌بندی‌های فعال (status = 1) را برمی‌گرداند
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }
}
