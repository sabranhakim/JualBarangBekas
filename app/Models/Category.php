<?php

// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'hakim_categories';

    protected $fillable = ['category_name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

