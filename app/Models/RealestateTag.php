<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealestateTag extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'realestate_id',
        'tag_id',
    ];
}
