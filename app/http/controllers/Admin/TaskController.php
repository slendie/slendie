<?php
namespace App\Http\Controllers\Admin;

use App\Controller;
use App\Models\Task;

use Slendie\Framework\Routing\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        $this->app->view('admin.tasks.index', ['tasks' => $tasks]);
    }

    public function create()
    {
        $this->app->view('admin.tasks.create');
    }

    public function store()
    {
        $request = request();

        $task = new Task();
        $task->description  = $request->description;
        $task->completed    = false;
        $task->save();

        return redirect('tasks.index');
    }

    public function edit($id)
    {
        $task = Task::find($id);
        $this->app->view('admin.tasks.edit', ['task' => $task]);
    }

    public function update($id)
    {
        $request = Request::getInstance();

        $task = Task::find($id);
        $task->description  = $request->description;
        $task->save();

        return redirect('tasks.index');
    }

    public function delete($id)
    {
        $request = Request::getInstance();

        $task = Task::find($id);
        $task->delete();
        return redirect('tasks.index');
    }
}