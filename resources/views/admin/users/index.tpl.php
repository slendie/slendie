@extends('admin.layouts.admin')
@section('content')
                    <h1 class="mt-4">Users</h1>
                    <p>Manage users</p>
                    @include('partials.alert')
                    <a class="btn btn-primary" href=" @route('users.create')">Novo utilizador</a><br>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>E-mail</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% if $users %}
                            {% foreach ($users as $user) %}
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a class="text-primary" href="@route('users.edit', ['id' => $user->id])">Edit</a>
                                    <form action="@route('users.delete', ['id' => $user->id])" method="POST" id="form-{{ $user->id }}" style="display: inline;">
                                    <a class="text-danger" href="#" onclick="submitForm('form-{{ $user->id }}')">Delete</a>
                                    </form>
                                </td>
                            </tr>
                            {% endforeach %}
                            {% endif %}
                        </tbody>
                    </table>
@endsection
@section('scripts')
<script>
function submitForm( formId )
{
    var form = document.getElementById(formId);
    form.submit();
}
</script>
@endsection