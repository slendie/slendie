@extends('auth.layouts.auth')
@section('content')
  <div class="alert-box">
    @include('partials.alert')
  </div>
  <div class="row">
    <div class="col-12 signin">
      <form class="form-signin" action="@route('auth.register')" method="POST">
        <h1 class="h3 mb-3 font-weight-normal">Register your account</h1>
        <div class="mb-3">
          <label for="inputEmail" class="sr-only">E-mail address</label>
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
        <div class="mb-3">
          <label for="inputPasswordConfirm" class="sr-only">Confirm password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
          {% if (has_error('password_confirmation')) %}
          <p class="small text-danger">{{ error('password_confirmation') }}</p>
          {% endif %}
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
        <a class="btn btn-lg btn-secondary" href="@route('auth.login')">Login</a>
        <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2018</p>
      </form>
    </div>
  </div>
@endsection
