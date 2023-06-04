<?php

namespace App\Models;

use App\Models\CompanyMultiImage;
use App\Models\CompanyTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Company extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    public $translatedAttributes = ['name', 'address', 'about', 'locale'];
    protected $fillable = ['user_id', 'email','map', 'website', 'mobile', 'telephone', 'fax', 'logo', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companytranslate()
    {
        return $this->belongsTo(CompanyTranslation::class);
    }


    public function images()
    {
        return $this->hasMany(CompanyMultiImage::class);
    }
}
