@extends('layouts.app')
@section('content')
        <!-- Page content-->
        <div class="container">
            <div class="mt-5 pb-5">
                <h1>{{ $card->title|html }}</h1>
                <p class="lead">{{ $card->resume|html }}</p>
                <p>{{ $card->content|html|blank }}</p>
            </div>
        </div>
@endsection