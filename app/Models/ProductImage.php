<?php

// app/Models/ProductImage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'hakim_product_images';

    protected $fillable = ['product_id', 'image_path'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

