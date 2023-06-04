<?php

namespace App\Models;

use App\Models\Guide;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuideTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['content', 'locale'];

    public function guide(){
        return $this->hasMany(Guide::class, 'guide_id','id');
    }
}
