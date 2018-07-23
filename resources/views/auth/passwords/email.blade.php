@extends('layouts.full')

@section('content')


<div class="card" style="width:450px;">
  <div class="card-body">
    <h5 class="card-title">Reset Password</h5>

    @if (session('status'))
        <div class="mt-3 alert alert-success">
            {{ session('status') }} 
        </div>
    @endif


    <form  method="POST" class="mt-3" action="{{ route('password.email') }}">
    {{ csrf_field() }}

        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
            <label for="email" class="control-label">E-Mail Address</label>
            <input id="email" type="email" class="form-control" name="email" placeholder="Enter Email" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-fill">
                Send Password Reset Link
            </button>
    </div>
    </form>


  </div>
</div>

@endsection
