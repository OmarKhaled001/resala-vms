<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventVolunteer extends Pivot
{
    use HasFactory;

    protected $table = 'event_volunteer';

    protected $fillable = [
        'volunteer_id',
        'event_id',
        'tshirt',
        'event_date',
    ];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
