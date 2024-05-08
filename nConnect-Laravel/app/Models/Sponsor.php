<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'link',
        'image'
    ];

    public function conferences()
    {
        return $this->belongsToMany(Conference::class);
    }
}
