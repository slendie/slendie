@extends('admin.layouts.admin')
@section('content')
                    <h1 class="mt-4">Users</h1>
                    <p>Create a new user</p>
                    @include('partials.alert')
                    <form action="@route('users.store')" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" required>
                                {% if (has_error('name')) %}
                                <p class="small text-danger">{{ error('name') }}</p>
                                {% endif %}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="email">E-mail</label>
                                <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required>
                                {% if (has_error('email')) %}
                                <p class="small text-danger">{{ error('email') }}</p>
                                {% endif %}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control" type="password" name="password" id="password" value="{{ old('password') }}" required>
                                {% if (has_error('password')) %}
                                <p class="small text-danger">{{ error('password') }}</p>
                                {% endif %}
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
                                {% if (has_error('password_confirmation')) %}
                                <p class="small text-danger">{{ error('password_confirmation') }}</p>
                                {% endif %}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <button class="btn btn-success" type="submit">Create</button>
                            </div>
                        </div>
                    </form>
@endsection