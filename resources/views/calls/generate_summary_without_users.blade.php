@extends('layouts.app')

@section('content')
<h3> Generate Summary </h3>
    <form action="{{ route('calls.retrieve_summary_without_users') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-center">
            <div class="mx-3"> <strong>From Date:</strong> <input type="text" name="fromdate" id="fromdate" class="from-control"> </div>
            <div class="mx-3"> <strong>To Date:</strong> <input type="text" name="todate" id="todate" class="from-control"> </div>                                      
        </div>
        <br>
        <div class="d-flex justify-content-center">
            <input type="submit" class="btn btn-primary px-3 py-1" value="Submit">
        </div>
    </form>    
@endsection
