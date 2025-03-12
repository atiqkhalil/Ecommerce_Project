<?php

namespace App\Models;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategories()
    {
    return $this->hasMany(SubCategory::class);
    }

}
