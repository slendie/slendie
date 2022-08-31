@extends('admin.layouts.admin')
@section('content')
                    <h1 class="mt-4">Tasks</h1>
                    <p>Edit your task</p>
                    @include('partials.alert')
                    <form action="@route('tasks.update', ['id' => $task->id])" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="description">Description</label>
                                <input class="form-control" type="text" name="description" id="description" value="{{ old('description', $task->description) }}">
                                {% if has_error('description') %}
                                <p class="small text-danger">{{ error('description') }}</p>
                                {% endif %}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
@endsection