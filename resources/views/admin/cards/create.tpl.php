@extends('admin.layouts.admin')
@section('content')
                    <h1 class="mt-4">Cards</h1>
                    <p>Create a new card</p>
                    @include('partials.alert')
                    <form action="@route('cards.store')" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="title">Title</label>
                                <input class="form-control" type="text" name="title" id="title" value="{{ old('title') }}">
                                {% if has_error('title') %}
                                <p class="small text-danger">{{ error('title') }}</p>
                                {% endif %}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="resume">Resume</label>
                                <textarea class="form-control" id="resume" name="resume" rows="5" cols="80">{{ old('resume') }}</textarea>
                                {% if has_error('resume') %}
                                <p class="small text-danger">{{ error('resume') }}</p>
                                {% endif %}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="content">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="15" cols="80">{{ old('content') }}</textarea>
                                {% if has_error('content') %}
                                <p class="small text-danger">{{ error('content') }}</p>
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