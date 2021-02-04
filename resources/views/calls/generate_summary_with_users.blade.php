@extends('layouts.app')

@section('content')
<h3> Generate Summary </h3>
    <form action="{{ route('calls.retrieve_summary_with_users') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-center">
            <div class="mx-3"> <strong>From Date:</strong> <input type="text" name="fromdate" id="fromdate" class="from-control"> </div>
            <div class="mx-3"> <strong>To Date:</strong> <input type="text" name="todate" id="todate" class="from-control"> </div>                         
            <div class="mx-3">
                <strong>Representative:</strong> 
                <select class="px-2 py-1" name="representative_id" id="representative_id">
                    <option class="text-muted" selected disabled>Choose a Representative</option>
                    @foreach ($all_representatives as $representative)
                        <option value="{{ $representative->representative_id }}">ID: {{ $representative->representative_id }} | Name: {{ $representative->name }} </option>
                    @endforeach          
                </select>                                
            </div> 
        </div>
        <br>
        <div class="d-flex justify-content-center">
            <input type="submit" class="btn btn-primary px-3 py-1" value="Submit">
        </div>
    </form>    

    {{-- @isset($calls)
    <div class="my-3">
        <table class="table table-striped table-bordered">
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
                @isset( $total_number_of_calls )
                <tr class="">
                    <th class="text-center" colspan="2">Total</th>
                    <th>{{ $total_number_of_calls }}</th>
                    <th>{{ $total_positive }}</th>
                    <th>{{ $total_get_admitted }}</th>
                </tr>         
                @endisset
            </tbody>
        </table>
    </div>
    @endisset     --}}

@endsection
