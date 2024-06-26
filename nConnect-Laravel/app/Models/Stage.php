<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date'
    ];

    public function conferences()
    {
        return $this->belongsToMany(Conference::class);
    }
    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }
}
