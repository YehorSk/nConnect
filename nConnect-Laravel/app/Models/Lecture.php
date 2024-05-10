<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'speaker_id',
        'stage_id',
        'conference_id',
        'name',
        'capacity',
        'start_time',
        'end_time',
    ];

    public function speaker():BelongsTo{
        return $this->belongsTo(Speaker::class);
    }
    public function stage():BelongsTo{
        return $this->belongsTo(Stage::class);
    }
    public function conference():BelongsTo{
        return $this->belongsTo(Conference::class);
    }

}