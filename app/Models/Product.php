<?php

namespace App\Models;

use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function images()
{
    return $this->hasMany(ProductImage::class);
}

public function image()
{
    return $this->hasMany(ProductImage::class, 'product_id');
}

public function product_ratings()
{
    return $this->hasMany(ProductsRating::class);
}


protected $fillable = [
    'title', // Add the title here
    'slug',
    'description',
    'price',
    'compare_price',
    'sku',
    'barcode',
    'track_qty',
    'qty',
    'status',
    'category_id',
    'sub_category_id',
    'brand_id',
    'is_featured',
    'short_description',
    'shipping_returns',
    'related_products',
];

}
