<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllTasks($user)
    {
        if ($user->role === 'admin') {
            return Task::all();
        } else {
            return Task::where('user_id', $user->id)->get();
        }
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function markComplete($id, $user)
    {
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();

        if (!$task) {
            return null;
        }

        $task->is_completed = true;
        $task->save();

        return $task;
    }

    public function delete($id)
    {
        $task = Task::find($id);
        return $task ? $task->delete() : false;
    }
}
