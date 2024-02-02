<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'file',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'user_id',
        'events_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function events()
    {
        return $this->belongsTo(Event::class, 'events_id', 'id');
    }
}
