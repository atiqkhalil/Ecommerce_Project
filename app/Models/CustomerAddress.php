<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = [
        'user_id',  // Add this line
        'first_name',
        'last_name',
        'email',
        'mobile',
        'country_id',
        'address',
        'apartment',
        'city',
        'state',
        'zip',
    ];

    // CustomerAddress.php (Model)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
