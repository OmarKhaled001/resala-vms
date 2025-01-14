<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Branch extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'branches';
    protected $guard = 'branch';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'username',
        'phone',
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
    
    public function activities()
    { 
        return $this->belongsToMany(Activity::class ,'branch_activity')->withTimestamps(); 
    }

    function volunteers()
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

    public function getMonthlyEventCount()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        return $this->events()
        ->whereBetween('event_date', [$startOfMonth, $endOfMonth])
        ->count() ;
      

    }

    public function getMonthlyEventConformingCount()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        return $this->events()
        ->where('status','conforming')
        ->whereBetween('event_date', [$startOfMonth, $endOfMonth])
        ->count() ;
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
