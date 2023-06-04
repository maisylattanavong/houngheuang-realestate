<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name', 'slug', 'category_id', 'locale'];

    public function categories()
    {
        return $this->belongTo(Category::class, 'category_id', 'id');
    }

    public function getRouteKeyName()
    {
        return "slug"; 
    }

}
