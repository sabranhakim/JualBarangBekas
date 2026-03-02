<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'hakim_orders';

    protected $fillable = [
        'user_id',
        'receiver_name',
        'phone',
        'address',
        'note',
        'status',
        'payment_gateway',
        'payment_reference',
        'payment_url',
        'paid_at',
        'payment_payload',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'payment_payload' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
