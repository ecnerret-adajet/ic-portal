@extends('layouts.full')

@section('content')


 <form class="form-signin" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

      <span class="h6 font-weight-bold mt-0 mb-0 text-muted text-uppercase">
          IC PORTAL
      </span>
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

      <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
        <label for="email" class="form-control-label">Email address</label>
      <input id="email"  type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
      </div>
      

      <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
            <label for="password" class="form-control-label">Password</label>
      <input id="password" type="password" class="form-control" name="password" required>
                @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                @endif
        </div>

      

        <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
        </div>

         <div class="form-group text-center">
                <button type="submit" class="d-block btn btn-primary btn-block">
                    Login
                </button>

                <a class="mt-3 btn btn-link text-center" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
        </div>
      
    
      {{-- <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button> --}}
      <p class="mt-3 mb-3 text-muted">&copy; La Filipina Uy Gongco Group of Companies</p>
    </form>


{{-- 
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
