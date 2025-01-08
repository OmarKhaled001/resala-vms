<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentRead extends Model
{
    use HasFactory;

    protected $table = 'comment_reads';

    protected $fillable = [
        'comment_id',
        'reader_id',
        'reader_type',
        'is_read',
    ];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function reader()
    {
        return $this->morphTo();
    }
}
