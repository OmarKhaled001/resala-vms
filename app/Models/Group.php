<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

     protected $table = 'groups';
    
     public $timestamps = true;

    protected $fillable = [
        'branch_id',
        'activity_id',
        'class',
        'category',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the branch that owns the group.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the activity that owns the group.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function getClass()
    {
        return match($this->class) {
            'first' => 'الاول',
            'second' => 'الثاني',
            'third' => 'الثالث',
            'fourth' => 'الرابع',
            'graduate' => 'متخرج',

            default => 'الاول', // قيمة افتراضية

        };
    }

      public function getMasaolCount()
    {
        return Volunteer::where('branch_id', $this->branch_id)
        ->where('activity_id', $this->activity_id)
        ->where('type','مسئول')
        ->count() ?? null ;
    }
    
    public function getMashroaaMasaolCount()
    {
        return Volunteer::where('branch_id', $this->branch_id)
        ->where('activity_id', $this->activity_id)
        ->where('type','مشروع مسئول')
        ->count()?? null ;
    }
    public function getMasaolCountAttributeCount()
    {
        return Volunteer::where('branch_id', $this->branch_id)
        ->where('activity_id', $this->activity_id)->where('type','مسئول')
        ->whereHas('events')
        ->count() ;
    }
    
    public function getMashroaaMasaolCountAttributeCount()
    {
        return Volunteer::where('branch_id', $this->branch_id)
        ->where('activity_id', $this->activity_id)->where('type','مشروع مسئول')
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
        return  round((Volunteer::where('branch_id', $this->branch_id)
        ->where('activity_id', $this->activity_id)
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
        return round((Volunteer::where('branch_id', $this->branch_id)
        ->where('activity_id', $this->activity_id)
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
        return Volunteer::where('branch_id', $this->branch_id)
        ->where('activity_id', $this->activity_id)
            ->whereBetween('vol_date', [$startOfMonth, $endOfMonth])
            ->count();
    }
}