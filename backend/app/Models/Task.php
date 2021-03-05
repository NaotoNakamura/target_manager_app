<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_id',
        'user_id',
        'task_title',
        'period_kind',
        'start_date',
        'end_date',
        'is_done'
    ];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
