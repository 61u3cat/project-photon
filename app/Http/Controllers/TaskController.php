<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->middleware('auth:api');
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $user = auth()->user();
        $tasks = $this->taskRepository->getAllTasks($user);

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'user_id' => 'required|exists:users,id'
        ]);

        $task = $this->taskRepository->create($request->all());

        return response()->json(['message' => 'Task created successfully', 'task' => $task]);
    }

    public function show($id)
    {
        $task = $this->taskRepository->getTaskById($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required',
            'description' => 'nullable',
            'due_date' => 'sometimes|required|date',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $task = $this->taskRepository->update($id, $validated);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json(['message' => 'Task updated successfully', 'task' => $task]);
    }

    public function destroy($id)
    {
        $deleted = $this->taskRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function markComplete($id)
    {
        $user = auth()->user();
        $task = $this->taskRepository->markComplete($id, $user);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json(['message' => 'Task marked as complete', 'task' => $task]);
    }

    public function markIncomplete($id)
    {
        $user = auth()->user();
        $task = $this->taskRepository->markIncomplete($id, $user);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json(['message' => 'Task marked as incomplete', 'task' => $task]);
    }

    public function getUserTasks()
    {
        $user = auth()->user();
        $tasks = $this->taskRepository->getAllTasks($user);

        return response()->json($tasks);
    }
}
