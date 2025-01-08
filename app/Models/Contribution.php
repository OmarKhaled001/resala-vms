<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;
    
    protected $table = 'contributions';
    
    public $timestamps = true;

    protected $fillable = [
        'name',
        'value',
        'is_active',
    
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public function sections()
    { 
        return $this->belongsToMany(Section::class ,'section_contribution')->withTimestamps(); 
    }

    function events()
    {
        return $this->hasMany(Event::class);
    }
}
