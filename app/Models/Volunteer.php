<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Volunteer extends Authenticatable
{
    use HasFactory  ,HasRolesAndPermissions;

    protected $table = 'volunteers';
    
    protected $guard = 'volunteer';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'username',
        'position',
        'national',
        'notes',
        'branch_id',
        'section_id',
        'activity_id',
        'phone',
        'gender',
        'birth_date',
        'vol_date',
        'address',
        'status',
        'type',
        'email',
        'password',
        'tshirt',
        'mine_camp',
        'camp_48',
    ];

    protected $casts = [
        'tshirt' => 'boolean',
        'mine_camp' => 'boolean',
        'camp_48' => 'boolean',
        'created_at' => 'datetime',
        'vol_date' => 'datetime',
        'email_verified_at' => 'datetime',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function section()
    { 
        return $this->belongsTo(Section::class); 
    }
    
    public function branch()
    { 
        return $this->belongsTo(Branch::class); 
    }
    
    public function activity()
    { 
        return $this->belongsTo(Activity::class); 
    }
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_volunteer')
                    ->withPivot('tshirt', 'event_date')
                    ->withTimestamps();
    }

    public function getTypeBadgeClass()
    {
        return match($this->type) {
            'مسئول' => 'bg-success',
            'مشروع مسئول' => 'badge-outline-info',
            'داخل المتابعة' => 'badge-outline-warning',
            'شبل' => 'badge-outline-warning',
            'خارج المتابعة' => 'bg-outline-danger',
            default => 'badge-outline-warning', // قيمة افتراضية

        };
    }

    public function getMonthlyCountAttribute()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        return $this->events()
        ->whereBetween('event_volunteer.event_date', [$startOfMonth, $endOfMonth])
        ->distinct('event_volunteer.event_date')
        ->count() ;
      

    }


    public function getCappedMonthlyParticipationAttribute()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
    
        $uniqueDailyParticipations = $this->events()
            ->whereBetween('event_volunteer.event_date', [$startOfMonth, $endOfMonth])
            ->distinct('event_volunteer.event_date')
            ->count();
    
        return min($uniqueDailyParticipations, 8);
    }
    

    public function authoredComments()
    {
        return $this->morphMany(Comment::class, 'authorable');
    }
    public function readComments()
    {
        return $this->morphMany(CommentRead::class, 'reader');
    }

}
