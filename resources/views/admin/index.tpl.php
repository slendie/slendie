@extends('admin.layouts.admin')
@section('content')
                    <div class="row m-4">
                        <div class="col-md-3">
                            <div class="card text-white bg-info">
                                <div class="card-header">
                                    <strong>Tarefas</strong>
                                </div>
                                <div class="card-body text-right">
                                    <h5 class="card-title">{{ \App\Models\Task::count() }} tarefas</h5>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection