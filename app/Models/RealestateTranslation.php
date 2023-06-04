<?php

namespace App\Models;

use App\Models\Realestate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RealestateTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['locale', 'title', 'slug', 'description','address'];

    public function realestates()
    {
        return $this->hasMany(Realestate::class, 'realestate_id', 'id');
    }

    public function getRouteKeyName()
    {
        return "slug";
    }
}
