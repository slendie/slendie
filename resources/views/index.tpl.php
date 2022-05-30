@extends('layouts.app')
@section('content')
            <!-- Heading Row-->
            <div class="row gx-4 gx-lg-5 align-items-center my-5">
                <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="https://dummyimage.com/900x400/dee2e6/6c757d.jpg" alt="..." /></div>
                <div class="col-lg-5">
                    <h1 class="font-weight-light">Business Name or Tagline</h1>
                    <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
                    <a class="btn btn-primary" href="#!">Call to Action!</a>
                </div>
            </div>
            <!-- Call to Action-->
            <div class="card text-white bg-secondary my-5 py-4 text-center">
                <div class="card-body"><p class="text-white m-0">This call to action card is a great place to showcase some important information or display a clever tagline!</p></div>
            </div>
            <!-- Content Row-->
            <div class="row gx-4 gx-lg-5">
                {% if $cards %}
                {% foreach ($cards as $card) %}
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">{{ $card->title|html }}</h2>
                            <p class="card-text">{{ $card->resume|html }}</p>
                        </div>
                        <div class="card-footer"><a class="btn btn-primary btn-sm" href="@route('cards.show', ['slug' => $card->slug])">More Info</a></div>
                    </div>
                </div>
                {% endforeach %}
                {% else %}
                <p>Não há cartões neste momento.</p>
                {% endif %}
            </div>
@endsection