@extends('admin.layouts.admin')
@section('content')
                    <h1 class="mt-4">Tasks</h1>
                    <p>Manage your tasks</p>
                    @include('partials.alert')
                    <a class="btn btn-primary" href=" @route('tasks.create')">Nova tarefa</a><br>
                    {% if $tasks %}
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% if $tasks %}
                            {% foreach ($tasks as $task) %}
                            <tr>
                                <td><input type="checkbox" name="complete-task-{{ $task->id }}" {% if $task->completed %}checked{% endif %} onclick="complete({{ $task->id }})" /></td>
                                <td {% if $task->completed %}class="completed"{% endif %}>{{ $task->description }}</td>
                                <td>
                                    <a class="text-primary" href="@route('tasks.edit', ['id' => $task->id])">Edit</a>
                                    <form action="@route('tasks.delete', ['id' => $task->id])" method="POST" id="form-{{ $task->id }}" style="display: inline;">
                                    <a class="text-danger" href="#" onclick="submitForm('form-{{ $task->id }}')">Delete</a>
                                    </form>
                                </td>
                            </tr>
                            {% endforeach %}
                            {% endif %}
                        </tbody>
                    </table>
                    {% else %}
                    <p class="mt-3">Não há tarefas criadas. Tenha um dia feliz!</p>
                    {% endif %}
@endsection
@section('scripts')
<script>
function submitForm( formId )
{
    var form = document.getElementById(formId);
    form.submit();
}
function complete( taskId )
{
    window.location.href = "@route('tasks.complete')?task=" + taskId;
}
</script>
@endsection