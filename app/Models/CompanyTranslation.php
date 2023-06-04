<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'address', 'about', 'locale'];

    public function companies(){
        return $this->hasMany(Company::class, 'company_id','id');
    }

}
