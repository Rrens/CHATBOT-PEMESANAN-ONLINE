<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recomendations extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'recomendations';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'id_customer',
        'created_at',
        'updated_at',
    ];

    public function customer()
    {
        return $this->hasMany(Customers::class, 'id', 'id_customer');
    }

    public function recomendation_detail()
    {
        return $this->belongsTo(Recomendation_detail::class);
    }
}
