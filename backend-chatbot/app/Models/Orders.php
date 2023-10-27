<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'id_customer',
        'courier',
        'resi_number',
        'address',
        'zipcode',
        'payment_status',
        'status',
        'link',
        'created_at',
        'updated_at',
    ];

    public function customer()
    {
        return $this->hasMany(Customers::class, 'id', 'id_customer');
    }

    public function order_detail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
