@extends('layouts.app')

@section('content')
<h3> Create Call Entries </h3>  
<form action="{{ route('calls.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if(auth()->user()->isAdmin)
        <div class="form-group">
            <label for="representative_id">Select Representative:</label>
            <select class="form-control" name="representative_id" id="representative_id">
                <option class="text-muted" selected disabled>Choose a Representative</option>
                @foreach ($representatives as $representative)
                    <option value="{{ $representative->representative_id }}">ID: {{ $representative->representative_id }} | Name: {{ $representative->name }} </option>
                @endforeach          
            </select>
        </div>
    @endif

    @if(!auth()->user()->isAdmin)
        <div class="form-group">
            <label for="representative_id">Select Representative:</label>
            <select class="form-control" name="representative_id" id="representative_id">                
                <option value="{{ $representative->representative_id }}">ID: {{ $representative->representative_id }} | Name: {{ $representative->name }} </option>                         
            </select>
        </div>
    @endif

    <div class="form-group">
        <label for="body"> No. of Calls: </label>
        <input type="number" class="form-control" name="number_of_calls" id="number_of_calls" placeholder="Enter Number Of Calls" value="{{ old('number_of_calls') }}"></input>
    </div>

    <div class="form-group">
        <label for="body"> Positive Responses: </label>
        <input type="number" class="form-control" name="positive" id="positive" placeholder="Enter Number of Positive Responses" value="{{ old('positive') }}"></input>
    </div>

    <div class="form-group">
        <label for="body"> Students Who Got Admitted: </label>
        <input type="number" class="form-control" name="got_admitted" id="got_admitted" placeholder="Enter Number of Students Who Got Admitted" value="{{ old('got_admitted') }}"></input>
    </div>      
        <br>
        <input type="submit" class="btn btn-primary" value="Submit">
    </form>
@endsection
