<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    
    protected $table = 'sections';
    
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'description',
        'is_active',
    
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

  
    
    public function activities()
    { 
        return $this->belongsToMany(Activity::class ,'activity_section')->withTimestamps(); 
    }

    public function contributions()
    { 
        return $this->belongsToMany(Contribution::class ,'section_contribution')->withTimestamps(); 
    }
    
    public function volunteers()
    {
        return $this->hasMany(Volunteer::class);
    }
    
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function getStatusBadgeClass()
    {

        return $this->is_active  ? 'bg-success' : 'bg-danger';

    }


    public function getStatusLabel()
    {
        return $this->is_active  ? 'مفعلة' : 'غير مفعلة';
   
    }
}
