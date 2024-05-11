<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'image',
        'phone_number',
        'email'

    ];
    public function conferences()
    {
        return $this->belongsToMany(Conference::class);
    }
}
