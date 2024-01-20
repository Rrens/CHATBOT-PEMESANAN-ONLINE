<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'whatsapp',
        'is_blokir',
        'is_distributor',
        'request_distributor',
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(Ordersrders::class);
    }

    public function recomendation()
    {
        return $this->belongsTo(Recomendations::class);
    }
}
