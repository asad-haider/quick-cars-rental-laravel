<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{

    protected $casts = ['rate' => 'float'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public function extras()
    {
        return $this->hasMany(Extra::class);
    }
}
