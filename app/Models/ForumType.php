<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumType extends Model
{
    use HasFactory;

    protected $table = 'forum_types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_forum_type', 'forum_type_id', 'user_id');
    }

    public function thread()
    {
        return $this->hasMany(Thread::class, 'forum_type_id', 'id');
    }
}
