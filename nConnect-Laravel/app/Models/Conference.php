<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conference extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'name',
        'is_current',
    ];

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class);
    }

    public function stages()
    {
        return $this->belongsToMany(Stage::class)->withPivot(['date']);
    }

    public function speakers()
    {
        return $this->belongsToMany(Speaker::class);
    }
    public function organizers()
    {
        return $this->belongsToMany(Organizer::class);
    }

    public function reviews() :HasMany{
        return $this->hasMany(Review::class);
    }

    public function gallery() :HasMany{
        return $this->hasMany(Gallery::class);
    }
    public function lectures() :HasMany{
        return $this->hasMany(Lecture::class);
    }

}
