<?php

namespace App\Models\CompaniesInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompaniesLogo extends Model
{
    use HasFactory;
    protected $fillable=['companies_name','logo'];
}
