@extends('auth.layouts.auth')
@section('content')
  <div class="row">
    <div class="col-12">
    @include('partials.alert')
    </div>
  </div>
  <div class="row">
    <div class="col-12 signin">
      <form class="form-signin" action="@route('signin')" method="POST">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <div class="mb-3">
          <label for="inputEmail" class="sr-only">Email address</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Email address" value="{{ old('email') }}" required autofocus>
          {% if (has_error('email')) %}
          <p class="small text-danger">{{ error('email') }}</p>
          {% endif %}
        </div>
        <div class="mb-3">
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
          {% if (has_error('password')) %}
          <p class="small text-danger">{{ error('password') }}</p>
          {% endif %}
        </div>
        <div class="checkbox mb-3">
          <label>
          <input type="checkbox" id="rememberme" name="rememberme" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2018</p>
      </form>
    </div>
  </div>
@endsection
