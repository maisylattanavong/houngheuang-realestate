<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PostMultipleImage;
use App\Models\Category;
use App\Models\Tag;
use App\Models\PostTranslation;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    public $translatedAttributes = ['locale', 'title', 'slug', 'description'];
    protected $fillable = [
        'user_id',
        'category_id',
        'status',
        'publish',
        'feature_image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function images()
    {
        return $this->hasMany(PostMultipleImage::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function posttranslate()
    {
        return $this->belongsTo(PostTranslation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
