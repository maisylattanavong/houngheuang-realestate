<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Realestate;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Category extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    public $translatedAttributes = ['name', 'slug', 'category_id', 'locale'];

    protected $fillable = [
        'user_id',
        'status',
        'image',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }

    public function realestates(){
        return $this->hasMany(Realestate::class,'category_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
