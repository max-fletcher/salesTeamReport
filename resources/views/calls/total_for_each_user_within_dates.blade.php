@extends('layouts.app')

@section('content')
<h3> Enter Dates to find Total for Each User </h3>
    <form action="{{ route('calls.calculate_total_for_each_user') }}" method="post" enctype="multipart/form-data">
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
