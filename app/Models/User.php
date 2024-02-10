<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $guarded = [
        'role',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'nip',
        'unit',
        'image',
        'bio',
        'is_ldap',
        'created_at',
        'updated_at',
        'role',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    public $timestamps = false;


    public function activities()
    {
        return $this->hasMany(UserActivity::class, 'user_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function forumTypes()
    {
        return $this->belongsToMany(ForumType::class, 'user_forum_type', 'user_id', 'forum_type_id');
    }

    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'user_id', 'id');
    }

    public function likes()
    {
        return $this->belongsToMany(Thread::class)->withTimestamps();
    }

    public function likesPost(Thread $thread)
    {
        return $this->likes()->where('thread_id', $thread->id)->exists();
    }

    public function roles()
    {
        return $this->hasOne(Role::class, 'id', 'role');
    }

    public function getImageURL()
    {
        if ($this->image) {
            return url('storage/' . $this->image);
        }
        return "/images/user_avatar_placeholder.png";
    }
}
