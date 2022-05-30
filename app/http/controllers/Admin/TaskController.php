<?php
namespace App\Http\Controllers\Admin;

use App\Controller;
use App\Models\Task;

use Slendie\Framework\Routing\Request;
use Slendie\Framework\Session\Flash;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('admin.tasks.create');
    }

    public function store()
    {
        $request = request();

        if ( empty($request->description) ) {
            Flash::error('A descrição não pode estar vazia.');
            Flash::setFieldError('description', 'A descrição é de preenchimento obrigatório.');
            return view('admin.tasks.create');
        }

        $task = new Task();
        $task->description  = $request->description;
        $task->completed    = false;
        $task->save();

        Flash::success('Tarefa criada com sucesso.');

        return redirect('tasks.index');
    }

    public function edit($id)
    {
        $task = Task::find($id);
        return view('admin.tasks.edit', compact('task'));
    }

    public function update($id)
    {
        $request = Request::getInstance();

        $task = Task::find($id);

        if ( empty($request->description) ) {
            Flash::error('A descrição não pode estar vazia.');
            Flash::setFieldError('description', 'A descrição é de preenchimento obrigatório.');
            return view('admin.tasks.edit', compact('task'));
        }

        $task->description  = $request->description;
        $task->save();

        Flash::success('Tarefa atualizada com sucesso.');

        return redirect('tasks.index');
    }

    public function delete($id)
    {
        $request = Request::getInstance();

        $task = Task::find($id);
        $task->delete();
        
        Flash::success('Tarefa eliminada com sucesso.');

        return redirect('tasks.index');
    }

    public function complete()
    {
        $request = Request::getInstance();

        $id = $request->task;

        $task = Task::find($id);
        $task->completed = ($task->completed ? false : true);
        $task->save();
        
        return redirect('tasks.index');
    }
}