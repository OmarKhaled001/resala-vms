<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Event extends Model implements HasMedia 
{
    use HasFactory , InteractsWithMedia ,LogsActivity;

    protected $table = 'events';

    protected $fillable = [
        'event_date', 
        'contribution_id', 
        'branch_id', 
        'section_id', 
        'activity_id', 
        'status', 
        'notes'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*']);
    }

    public function volunteers()
    {
        return $this->belongsToMany(Volunteer::class, 'event_volunteer')
                    ->withPivot('tshirt', 'event_date')
                    ->withTimestamps();
    }

    public function contribution()
    {
        return $this->belongsTo(Contribution::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'badge-outline-info',
            'conforming' => 'bg-success',
            'non-conforming' => 'badge-outline-warning',
            'rejected' => 'bg-danger',
        };
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            'pending' => 'معلق',
            'conforming' => 'مطابق',
            'non-conforming' => 'غير مطابق',
            'rejected' => 'مرفوض',
        };
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
