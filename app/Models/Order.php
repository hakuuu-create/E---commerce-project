<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'grand_total',
        'payment_method',
        'payment_status',
        'status',
        'currency',
        'shipping_amount',
        'shipping_method',
        'notes',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    //setiap order bisa memiliki banyak Item
    public function items(){
        return $this->hasMany(OrderItem::class);
    }
    //setiap order memiliki SATU address
    public function address(){
        return $this->hasOne(Address::class);
    }

}
