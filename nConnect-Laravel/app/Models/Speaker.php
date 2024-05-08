<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'picture',
        'short_desc',
        'long_desc',
        'Company',
        'Instagram',
        'LinkedIn',
        'Facebook',
        'Twitter',
    ];

    public function conferences()
    {
        return $this->belongsToMany(Conference::class);
    }

    public function lectures() :HasMany{
        return $this->hasMany(Lecture::class);
    }

}
