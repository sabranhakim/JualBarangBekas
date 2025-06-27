<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'hakim_products';

    protected $fillable = ['user_id', 'category_id', 'name', 'description', 'price', 'status', 'phone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function favoredBy()
    {
        return $this->belongsToMany(User::class, 'hakim_favorites')->withTimestamps();
    }
}
