<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadCategory extends Model
{
    use HasFactory;

    protected $table = 'thread_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    public function threads()
    {
        return $this->hasMany(Thread::class, 'thread_category_id', 'id');
    }
}
