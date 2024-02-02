<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $with = [
        'user:id,name,image',
        'comments.user:id,name,image',
    ];
    protected $table = 'threads';
    protected $primaryKey = 'id';
    protected $guarded = [
        'created_at',
        'created_by',
        'user_id',
        'forum_types_id',
    ];
    protected $fillable = [
        'title',
        'content',
        'file',
        'updated_at',
        'updated_by',
        'thread_categories_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function forumTypes()
    {
        return $this->belongsTo(ForumType::class, 'forum_type_id', 'id');
    }

    public function threadCategories()
    {
        return $this->belongsTo(ThreadCategory::class, 'thread_category_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
