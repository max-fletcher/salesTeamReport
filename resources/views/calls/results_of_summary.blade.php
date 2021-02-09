@extends('layouts.app')

@section('content')
@isset($calls)
    <div class="my-3">
        <h3> Results of Summary </h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> Representative_ID </th>
                    <th> Full Name </th>
                    <th> No. of Calls </th>
                    <th> Positive </th>
                    <th> Got Admitted </th>    
                    <th> Date </th>
                    {{-- LATER
                        <th> Edit </th>   
                    --}} 
                    <th> Delete </th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($calls as $call)
                <tr>
                    <td> {{ $call->representative_id }} </td>
                    @isset($call->user->name)
                        <td> {{ $call->user->name }} </td>
                    @else
                        <td class="text-danger"> Deleted From Database </td>
                    @endif
                    <td> {{ $call->number_of_calls }} </td>
                    <td> {{ $call->positive }} </td>
                    <td> {{ $call->get_admitted }} </td>
                    <td> {{ $call->created_at->format('d/m/Y') }} </td>
                    {{-- Later
                    <td> <a class="btn btn-info" href="{{ route('calls.edit', $call->id) }}"> Edit </a> </td>
                    <td> <a class="btn btn-danger" href="{{ route('calls.delete', $call->id) }}"> Delete </a> </td> --}}
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
    @else
        <div class="text-center"> 
            <br>           
            <h2> The "From Date" is greater than the "To Date" field !! </h2>
        </div>
    @endisset    

@endsection
