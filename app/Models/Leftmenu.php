<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leftmenu extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id',
        'icons',
        'title',
    ];
    public function childs(){
        return $this->hasMany(Leftmenu::class, 'parent_id', 'id');
    }
}
