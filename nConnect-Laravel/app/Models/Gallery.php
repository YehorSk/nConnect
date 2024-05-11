<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'conference_id',
        'image',
        'year'
    ];

    public function conferences()
    {
        return $this->belongsTo(Conference::class, 'conferences_id');
    }
}
