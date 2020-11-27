@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center">
                <h3>Confirm your mail address</h3>
            </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
  </div>
@endif
@if($message = session('msg'))
    <div class="alert alert-danger">{!! $message !!}</div>
@endif
  <div class="form-group">
    <form method="post" action="/mail">
        @csrf
        @method('PATCH')
    <label for="otp">OTP</label>
    <input type="text" class="form-control" id="otp" name="otp">
    <small id="otp" class="form-text text-muted">enter the otp that we sent to your email.</small>
     <input type="submit" class="btn btn-primary">
  </div>

 
</form>
            </div>
        </div>
    </div>
</div>
@endsection