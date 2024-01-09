<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'capacity', 'start_date', 'end_date', 'owner_id'];

    public function owner() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function attendees() : HasMany {
        return $this->hasMany(Attendee::class);
    }
}
