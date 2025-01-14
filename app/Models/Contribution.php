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

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function getStatusBadgeClass()
    {

        return $this->is_active  ? 'bg-success' : 'bg-danger';

    }

    public function getTypeBadgeClass()
    {

        return $this->value  == 2 ? 'badge-outline-info' : 'bg-success';

    }

    public function getTypeLabel()
    {
 
        return $this->value  == 2 ? 'من المنزل' :  'ميدانية' ;
    }

    public function getStatusLabel()
    {
        return $this->is_active  ? 'مفعلة' : 'غير مفعلة';
   
    }


    
}
