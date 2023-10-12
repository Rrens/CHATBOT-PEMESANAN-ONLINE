<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promos extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'promos';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'id_menu',
        'name',
        'discount',
        'created_at',
        'updated_at',
    ];

    public function menu()
    {
        return $this->hasMany(Menus::class, 'id', 'id_menu');
    }
}
