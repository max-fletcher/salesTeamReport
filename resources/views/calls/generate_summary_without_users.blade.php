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

    @isset($calls)
    <div class="my-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> Representative_ID </th>
                    <th> Name </th>
                    <th> No. of Calls </th>
                    <th> Positive </th>
                    <th> Got Admitted </th>    
                    <th> Date </th>
                    <th> Edit </th>    
                    <th> Delete </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($calls as $call)
                <tr>
                    <td> {{ $call->representative_id }} </td>
                    <td> {{ $call->user->name }} </td>
                    <td> {{ $call->number_of_calls }} </td>
                    <td> {{ $call->positive }} </td>
                    <td> {{ $call->get_admitted }} </td>
                    <td> {{ $call->created_at->format('d/m/Y') }} </td>
                    <td> <a class="btn btn-info" href="{{ route('calls.edit', $call->id) }}"> Edit </a> </td>
                    <td> <a class="btn btn-danger" href="{{ route('calls.delete', $call->id) }}"> Delete </a> </td>
                </tr>                           
                @endforeach              
            </tbody>
        </table>
    </div>
    @endisset    

@endsection
