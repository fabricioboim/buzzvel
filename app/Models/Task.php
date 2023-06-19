<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'attachment',
        'completed',
        'created_at',
        'completed_at',
        'updated_at',
        'deleted_at',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createNewTask($data)
    {

        $completed = isset($data['completed']) ? (bool) $data['completed'] : false;
        $completedAt = $completed ? now() : null;

        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'attachment' => isset($data['file']) ? $data['file']->storeAs('attach', $data['file']->getClientOriginalName()) : null,
            'completed' => $completed,
            'completed_at' => $completedAt,
            'user_id' => isset($data['user_id']) ? $data['user_id'] : auth()->id(),
        ]);

        return $task;
    }

}
