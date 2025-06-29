<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Models\Task;

class WebFrontendController extends Controller
{
    public function showRegister()
    {
        return view('pages.register');
    }

    public function showLogin()
    {
        return view('pages.login');
    }

    public function registerUser(Request $request)
    {
        try {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'role'     => 'user',
            ]);

            return redirect('/login')->with('message', 'Registered! Now log in.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $user = JWTAuth::user();
        session(['token' => $token, 'user_id' => $user->id, 'role' => $user->role]);

        return redirect('/tasks-view')->with('message', 'Logged in successfully!');
    }

    public function tasksView()
    {
        try {
            $token = session('token');
            if (!$token) return redirect('/login')->withErrors(['error' => 'Please login first.']);

            $user = JWTAuth::setToken($token)->authenticate();
            if (!$user) return redirect('/login')->withErrors(['error' => 'Invalid token. Login again.']);

            $tasks = $user->role === 'admin' ? Task::all() : $user->tasks;

            return view('pages.tasks', [
                'tasks' => $tasks,
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load tasks: ' . $e->getMessage()]);
        }
    }

    public function createTask(Request $request)
    {
        try {
            $token = session('token');
            $user = JWTAuth::setToken($token)->authenticate();

            if ($user->role !== 'admin') {
                return back()->withErrors(['error' => 'Unauthorized.']);
            }

            $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date'    => 'required|date',
                'user_id'     => 'required|exists:users,id',
            ]);

            Task::create([
                'title'       => $request->title,
                'description' => $request->description,
                'due_date'    => $request->due_date,
                'user_id'     => $request->user_id,
                'is_completed'=> false,
            ]);

            return back()->with('message', 'Task created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Task creation failed: ' . $e->getMessage()]);
        }
    }

    public function completeTask($id)
    {
        try {
            $token = session('token');
            $user = JWTAuth::setToken($token)->authenticate();

            $task = Task::where('id', $id)->where('user_id', $user->id)->first();
            if (!$task) {
                return back()->withErrors(['error' => 'Task not found or not yours.']);
            }

            $task->is_completed = true;
            $task->save();

            return back()->with('message', 'Task marked as completed.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to complete task: ' . $e->getMessage()]);
        }
    }

    public function deleteTask($id)
    {
        try {
            $token = session('token');
            $user = JWTAuth::setToken($token)->authenticate();

            if ($user->role !== 'admin') {
                return back()->withErrors(['error' => 'Unauthorized.']);
            }

            $task = Task::find($id);
            if (!$task) {
                return back()->withErrors(['error' => 'Task not found.']);
            }

            $task->delete();

            return back()->with('message', 'Task deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete task: ' . $e->getMessage()]);
        }
    }
}
