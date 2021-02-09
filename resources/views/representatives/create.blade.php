@extends('layouts.app')

@section('content')
  <h3> Create Representatives </h3>
    <form action="{{ route('representatives.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      
      <div class="form-group">
        <label for="representative_id">Representative ID</label>
        <input type="number" class="form-control" name="representative_id" id="representative_id" placeholder="Enter Representative ID" value="{{ old('representative_id') }}">
      </div>      
      
      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Representative Name" value="{{ old('name') }}"></input>
      </div>

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Enter Representative Username" value="{{ old('username') }}"></input>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="text" class="form-control" name="password" id="password" placeholder="Enter Representative Password"></input>
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="text" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Representative Password"></input>
      </div>

      <br>
      <input type="submit" class="btn btn-primary" value="Submit">
    </form>
@endsection
