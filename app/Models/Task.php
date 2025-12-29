<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'created_by',
        'title',
        'task_details',
        'work_update',
        'start_date',
        'due_date',
        'status',
    ];

    // 🔗 Assigned User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔗 Admin / Creator
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // 🔥 DAILY WORK UPDATES (HISTORY)
}
