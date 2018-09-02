@extends('layouts.full')

@section('content')

<div class="card" style="width:450px;">
  <div class="card-body">
    <h3 class="card-title">Assignment Portal</h3>
    <p class="card-text text-muted">Please sign in</p>


    <form  method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
        <label for="email" class="form-control-label">Email address</label>
      <input id="email"  type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Enter Email" required autofocus>
            @if ($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
      </div>


      <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
            <label for="password" class="form-control-label">Password</label>
      <input id="password" type="password" class="form-control" name="password" placeholder="Enter Password" required>
                @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                @endif
    </div>


    <button type="submit" class="mt-4  btn btn-primary btn-fill btn-block">Sign In</button>
    <a href="{{ route('password.request') }}" class="my-3   btn btn-secondary btn-fill btn-block">Forgot Password ?</a>


    </form>

  </div>
</div>
@endsection
