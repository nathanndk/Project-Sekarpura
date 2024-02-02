<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'content',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'user_id',
        'thread_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function threads()
    {
        return $this->belongsTo(Thread::class, 'thread_id', 'id');
    }
}
