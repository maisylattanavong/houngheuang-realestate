<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpCount extends Model
{
    use HasFactory;
    protected $fillable = [];

    public function ipCount()
    {
        return $this->belongsTo(VisitorCount::class);
    }
}
