<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';
    
    public $timestamps = true;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function branches()
    { 
        return $this->belongsToMany(Branch::class ,'branch_activity')->withTimestamps(); 
    }

    public function sections()
    { 
        return $this->belongsToMany(Section::class ,'activity_section')->withTimestamps(); 
    }
    
    public function volunteers()
    {
        return $this->hasMany(Volunteer::class);
    }
    
    function events()
    {
        return $this->hasMany(Event::class);
    }

    public function authoredComments()
    {
        return $this->morphMany(Comment::class, 'authorable');
    }

    public function readComments()
    {
        return $this->morphMany(CommentRead::class, 'reader');
    }

    public function getMasaolCount()
    {
        return $this->volunteers()->where('type','مسئول')
        ->count() ?? null ;
    }
    
    public function getMashroaaMasaolCount()
    {
        return $this->volunteers()->where('type','مشروع مسئول')
        ->count()?? null ;
    }
    public function getMasaolCountAttributeCount()
    {
        return $this->volunteers()->where('type','مسئول')
        ->whereHas('events')
        ->count() ;
    }
    
    public function getMashroaaMasaolCountAttributeCount()
    {
        return $this->volunteers()->where('type','مشروع مسئول')
        ->whereHas('events')
        ->count() ;
    }

    public function getMasaolCountAttribute()
    {
        $count = $this->getMasaolCount(); 
        if ($count == 0) 
        { 
            return 0;
        }
        return  round(($this->volunteers()
            ->where('type', 'مسئول')
            ->get()
            ->sum(function ($volunteer) {
                return $volunteer->capped_monthly_participation;
            })  /  $count),2);
    }
    
    public function getMashroaaMasaolCountAttribute()
    {
        $count = $this->getMashroaaMasaolCount(); 
        if ($count == 0) 
        { 
            return 0;
        }
        return round(($this->volunteers()
            ->where('type', 'مشروع مسئول')
            ->get()
            ->sum(function ($volunteer) {
                return $volunteer->capped_monthly_participation;
            }) /  $count),2);
    }
    public function getNewVolunteersCount()
    {
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();
        return $this->volunteers()
            ->whereBetween('vol_date', [$startOfMonth, $endOfMonth])
            ->count();
    }
    
}
