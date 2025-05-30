<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function orders()
    {
        return $this->hasMany(Order::class, 'country_id');
    }
}
