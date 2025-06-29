<?php

namespace App\Repositories\Interfaces;

interface TaskRepositoryInterface
{
    public function getAllTasks($user);
    public function create(array $data);
    public function markComplete($id, $user);
    public function delete($id);
}
