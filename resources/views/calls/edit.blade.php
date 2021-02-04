@extends('layouts.app')

@section('content')
<h3> Edit Representatives </h3>  
<form action="{{ route('calls.update') }}" method="post" enctype="multipart/form-data">
    @method('patch')
    @csrf
    <div class="form-group">
        <label for="representative_id">Select Representative:</label>
        <select class="form-control" name="representative_id" id="representative_id">            
                <option value="{{ $call->user->representative_id }}">ID: {{ $call->user->representative_id }} | Name: {{ $call->user->name }} </option>            
        </select>
    </div>

    <div class="form-group">
        <label for="body"> No. of Calls: </label>
        <input type="number" class="form-control" name="number_of_calls" id="number_of_calls" placeholder="Enter Number Of Calls" value="{{ $call->number_of_calls }}"></input>
    </div>

    <div class="form-group">
        <label for="body"> Positive Responses: </label>
        <input type="number" class="form-control" name="positive" id="positive" placeholder="Enter Number of Positive Responses" value="{{ $call->positive }}"></input>
    </div>

    <div class="form-group">
        <label for="body"> Students Who Got Admitted: </label>
        <input type="number" class="form-control" name="got_admitted" id="got_admitted" placeholder="Enter Number of Students Who Got Admitted" value="{{ $call->get_admitted }}"></input>
    </div>

    <input type="hidden" class="form-control" name="call_id" id="call_id" value="{{ $call->id }}"></input>

    <br>
    <input type="submit" class="btn btn-primary" value="Submit">

    </form>
@endsection
