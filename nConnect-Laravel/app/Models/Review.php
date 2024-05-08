<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'conference_id',
        'name',
        'text',
        'photo'
    ];

    public function conference():BelongsTo{
        return $this->belongsTo(Conference::class);
    }
}
