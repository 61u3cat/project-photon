<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ $user->name }}'s Tasks</h3>
                    <a href="/logout" class="btn btn-sm btn-outline-light">Logout</a>
                </div>
                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    @if(isset($tasks) && count($tasks))
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>{{ $task['title'] }}</td>
                                        <td>{{ $task['description'] }}</td>
                                        <td>{{ $task['due_date'] }}</td>
                                        <td>
                                            @if($task['is_completed'])
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$task['is_completed'] && $user->role === 'user')
                                                <a href="/complete-task/{{ $task['id'] }}" class="btn btn-sm btn-outline-success">✔ Mark Complete</a>
                                            @endif
                                            @if($user->role === 'admin')
                                                <a href="/delete-task/{{ $task['id'] }}" class="btn btn-sm btn-outline-danger">🗑 Delete</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info text-center">No tasks found.</div>
                    @endif

                    @if($user->role === 'admin')
                        <hr>
                        <h4>Create New Task</h4>
                        <form method="POST" action="/create-task" class="row g-3">
                            @csrf
                            <div class="col-md-6">
                                <input type="text" name="title" class="form-control" placeholder="Title" required>
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="due_date" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <textarea name="description" class="form-control" placeholder="Description"></textarea>
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="user_id" class="form-control" placeholder="Assign to User ID" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Create Task</button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
