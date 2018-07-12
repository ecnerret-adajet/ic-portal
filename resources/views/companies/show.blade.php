@extends('layouts.app')

@section('content')
<div class="container-fluid">

       <!-- Content Header (Page header) -->
    <div class="content-header mb-3 mt-1">
        <div class="row">
          <div class="col pt-3">
            <span class="h2" style="font-weight: bold">{{ $company->name }}</span>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>


    <company-show company_id="{{ $company->id }}"></company-show>



</div>
@endsection
