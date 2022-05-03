@extends('admin.layouts.admin')
@section('content')
                    <h1 class="mt-4">Tasks</h1>
                    <p>Manage your tasks</p>
                    <form action="@route('tasks.store')" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="description">Description</label>
                                <input class="form-control" type="text" name="description" id="description">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button class="btn btn-success" type="submit">Create</button>
                            </div>
                        </div>
                    </form>
@endsection