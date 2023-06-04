<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedial extends Model
{
    use HasFactory;

    protected $fillable =['name','URL_path','icons_image'];
}
