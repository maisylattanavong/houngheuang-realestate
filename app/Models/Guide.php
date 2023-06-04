<?php

namespace App\Models;

use App\Models\GuideTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guide extends Model
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['content','locale'];
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guidetranslate()
    {
        return $this->belongsTo(GuideTranslation::class);
    }
}
