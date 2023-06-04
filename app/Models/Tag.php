<?php

namespace App\Models;

use App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    public $translatedAttributes = ['name', 'slug', 'locale', 'tag_id'];
    protected $fillable = ['user_id', 'status'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }

    public function realestates(){
        return $this->belongsToMany(Realestate::class,'realestate_tags');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
