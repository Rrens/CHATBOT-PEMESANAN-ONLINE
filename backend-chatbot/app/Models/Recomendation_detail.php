<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recomendation_detail extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'recomendation_detail';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'id_recomendation',
        'id_menu',
        'created_at',
        'updated_at',
    ];

    public function menu()
    {
        return $this->hasMany(Menus::class, 'id', 'id_menu');
    }

    public function recomendation()
    {
        return $this->hasMany(Recomendations::class, 'id', 'id_recomendation');
    }
}
