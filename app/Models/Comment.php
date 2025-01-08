<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'authorable_id', 'authorable_type','event_id'];

  
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function authorable()
    {
        return $this->morphTo();
    }

    public function readers()
    {
        return $this->morphToMany(
            User::class, 
            'reader', 
            'comment_reads'
        )->withPivot('is_read')->withTimestamps();
    }

}
