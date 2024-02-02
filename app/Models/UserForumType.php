<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserForumType extends Model
{
    use HasFactory;

    protected $table = 'user_forum_types';
    protected $primaryKey = ['user_id', 'forum_types_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function forumType()
    {
        return $this->belongsTo(ForumType::class, 'forum_type_id', 'id');
    }
}
