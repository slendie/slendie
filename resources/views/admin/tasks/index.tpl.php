@extends('admin.layouts.admin')
@section('content')
                    <h1 class="mt-4">Tasks</h1>
                    <a class="btn btn-primary" href=" @route('tasks.create')">Nova tarefa</a><br>
                    <p>Manage your tasks</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for( $tasks as $task )
                            <tr>
                                <td><input type="checkbox" name="complete-task-{{ $task->id }}" /></td>
                                <td>{{ $task->description }}</td>
                                <td><a class="text-danger" href="@route('tasks.delete', ['id' => $task->id])">Delete</a></td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
@endsection