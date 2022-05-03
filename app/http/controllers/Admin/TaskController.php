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

        // dd(['TaskController::store', $request]);

        $task = new Task();
        $task->description  = $request->description;
        $task->completed    = false;
        $task->save();

        // $this->app->view('admin.tasks.create');
        return redirect('tasks.index');
    }

    public function delete($id)
    {
        $request = new Request();

        $task = Task::find($id);
        dd(['TaskController::delete', $id, $request]);
        $task->delete();
        return redirect('tasks.index');
    }
}