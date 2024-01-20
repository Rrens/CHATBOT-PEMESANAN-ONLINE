<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'order_detail';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'id_order',
        'id_menu',
        'id_promo',
        'promo_amount',
        'price',
        'quantity',
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->hasMany(Orders::class, 'id', 'id_order');
    }

    public function menu()
    {
        return $this->hasMany(Menus::class, 'id', 'id_menu');
    }

    public function promo()
    {
        return $this->hasMany(Promos::class, 'id', 'id_menu');
    }
}
