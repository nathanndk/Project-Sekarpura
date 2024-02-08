<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'ref_id',
        'modules',
        'keterangan',
        'isRead',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
