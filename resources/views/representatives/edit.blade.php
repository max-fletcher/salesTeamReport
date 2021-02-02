@extends('layouts.app')

@section('content')
<h3 class="pb-3"> Edit Representatives </h3>
    <form action="{{ route('representatives.update') }}" method="post" enctype="multipart/form-data">
        @method('patch')
        @csrf              

        @if(auth()->user()->isAdmin)
            <div class="form-group">
                <label for="representative_id">Representative ID</label>
                <input type="number" class="form-control" name="representative_id" id="representative_id" placeholder="Enter Representative ID" value="{{ $representative->representative_id }}">
            </div>
        @else
            <input name="representative_id" id="representative_id" type="hidden" value="{{ $representative->representative_id }}">
        @endif
        

        <div class="form-group">
            <label for="body">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Representative Name" value="{{ $representative->name }}"></input>
        </div>

        <div class="form-group">
            <label for="body">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Enter Representative Username" value="{{ $representative->username }}"></input>
        </div>

    <input type="hidden" class="form-control" name="password" id="password" value="{{ $representative->password }}"></input>      
    <input type="hidden" class="form-control" name="id" id="id" value="{{ $representative->id }}"></input>      

        <br>
        <input type="submit" class="btn btn-primary" value="Submit">
    </form>
@endsection
