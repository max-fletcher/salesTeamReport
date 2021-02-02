@extends('layouts.app')

@section('content')
<h3> Summary of All Calls </h3>
<div class="container">
    <div class="row justify-content-center">                          
    @if(count($calls) > 0)
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
                <th>Delete</th>            
                
                
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
                

                @if (auth()->user()->isAdmin || auth()->user()->representative_id == $call->representative_id)
                    <td> <a class="btn btn-info" href="{{ route('calls.edit', $call->id) }}"> Edit </a> </td>
                    <td> <a class="btn btn-danger" href="{{ route('calls.delete', $call->id) }}"> Delete </a> </td>                
                @else
                    <td> <p class="btn btn-dark"> Not Your Account </p> </td>
                    <td> <p class="btn btn-dark"> Not Your Account </p> </td>
                @endif                
            </tr>                           
            @endforeach              
        </tbody>
    </table>
    @else
        <h1 class="pt-5"> No Call Entries for this User Yet !! </h1>       
    @endif
    </div>
</div>
@endsection
