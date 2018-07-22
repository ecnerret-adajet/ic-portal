@extends('layouts.app')

@section('content')
<div class="container">

       <!-- Content Header (Page header) -->
    <div class="content-header mb-3 mt-4">
        <div class="row">
          <div class="col pt-3">
            <span class="h2">Register User</span>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>


    {!! Form::model($user = new \App\User, ['url' => 'users', 'files' => 'true', 'enctype' => 'multipart\form-data']) !!}
    {!! csrf_field() !!}
        <form>
            @include('users.form')
        </form>
    {!! Form::close() !!}  



</div>
@endsection
