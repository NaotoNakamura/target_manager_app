<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_title',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
