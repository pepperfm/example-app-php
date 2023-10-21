<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App\App;
use App\App\Database\QueryBuilder;
use App\Models\Task;

class TaskController
{
    protected string $table;

    protected QueryBuilder $query;

    protected ?\App\Models\User $user = null;

    public function __construct()
    {
        $this->table = 'tasks';
        $this->query = App::get('DB');
        $this->user = App::get('user');
    }

    /**
     * @throws \Exception
     */
    public function index()
    {
        $page = (int) trim(strip_tags($_GET['page'] ?? '1'));
        $sortField = trim(strip_tags($_GET['sort'] ?? 'id'));
        $order = trim(strip_tags($_GET['order'] ?? 'asc'));

        $totalCount = $this->query->count($this->table);

        $tasks = $this->query->selectAll(
            table: $this->table,
            modelClass: Task::class,
            sortField: $sortField,
            order: $order,
            page: $page,
        );
        $total = count($tasks);
        $title = 'Tasks lists';

        return view('tasks.index', [
            'tasks' => $tasks,
            'title' => $title,
            'total' => $total,
            'page' => $page,
            'order' => $order,
            'sortField' => $sortField,
            'lastPage' => ceil($totalCount / 3),
            'user' => $this->user,
        ]);
    }

    public function create()
    {
        $title = 'Create new Task';

        return view('tasks.create', compact('title'));
    }

    public function store()
    {
        $params = [
            'name' => (empty($_POST['name'])) ? '' : trim(strip_tags($_POST['name'])),
            'email' => (empty($_POST['email'])) ? '' : trim(strip_tags($_POST['email'])),
            'text' => (empty($_POST['text'])) ? '' : trim(strip_tags($_POST['text'])),
        ];

        if (empty($params['name'])) {
            return redirect('tasks/create');
        }

        try {
            $this->query->insert($this->table, $params);
        } catch (\Exception $e) {
            view('500');
        }

        return redirect('tasks');
    }

    public function edit()
    {
        if (!isset($_GET['id'])) {
            require 'views/404.php';
            exit(0);
        }

        $id = (int) trim(strip_tags($_GET['id']));

        $task = $this->query->first($this->table, Task::class, $id);
        if (empty($task)) {
            return view('404');
        }

        $task = $task[0];
        $title = $task->name . ' | Tasks edit';

        return view('tasks.update', compact('task', 'title'));
    }

    public function update()
    {
        if (!isset($_GET['id'])) {
            return view('404');
        }

        $id = (int) trim(strip_tags($_GET['id']));

        $task = $this->query->first($this->table, Task::class, $id);
        if (empty($task)) {
            return view('404');
        }
        $inputStatus = filter_var($_POST['status'], FILTER_VALIDATE_INT);

        $params = [
            'name' => (empty($_POST['name'])) ? '' : trim(strip_tags($_POST['name'])),
            'email' => (empty($_POST['email'])) ? '' : trim(strip_tags($_POST['email'])),
            'text' => (empty($_POST['text'])) ? '' : trim(strip_tags($_POST['text'])),
            'status' => $inputStatus ?? 0,
        ];

        if (empty($params['name'])) {
            return view('500');
        }

        try {
            $this->query->update($this->table, $params, $id);
        } catch (\Exception $e) {
            return view('500');
        }

        return redirect('tasks');
    }

    public function delete()
    {
        if (!isset($_GET['id'])) {
            return view('404');
        }

        $id = (int) trim(strip_tags($_GET['id']));

        $task = $this->query->first($this->table, Task::class, $id);
        if (!empty($task)) {
            $this->query->delete($this->table, $id);
        }

        return redirect('tasks');
    }
}
