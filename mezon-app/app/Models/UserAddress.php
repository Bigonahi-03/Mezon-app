<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{

    protected $table = 'users_addresses';

    protected $fillable = ['user_id', 'province', 'city', 'address', 'postal_code', 'latitude', 'longitude', 'cellphone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
