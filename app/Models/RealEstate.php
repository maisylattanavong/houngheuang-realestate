<?php

namespace App\Models;

use App\Models\Category;
use App\Models\RealestateMultiImage;
use App\Models\RealestateTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Realestate extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    public $translatedAttributes = ['locale', 'title', 'slug', 'description','address'];
    protected $fillable = [
        'user_id',
        'category_id',
        'status',
        'publish',
        'hot_property',
        'recommended_property',
        'feature_image',
        'price',
        'area',
        'longitude',
        'latitude',
        'map'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function realestateimages()
    {
        return $this->hasMany(RealestateMultiImage::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'realestate_tags');
    }

    public function realestatetranslate()
    {
        return $this->belongsTo(RealestateTranslation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

