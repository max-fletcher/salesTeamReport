@extends('layouts.app')

@section('content')
<h3> Total For Each User</h3>
<h5 class="text-center">Searched Within Dates: <strong> {{$fromdate}} </strong> to <strong> {{$todate}} </strong> </h5>
<br>
    @isset($user_totals)
        <div class="my-3">                           
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th> Representative_ID </th>
                        <th> Full Name </th>
                        <th> Username </th>
                        <th> Total Calls </th>
                        <th> Total Positive </th>    
                        <th> Total Got Admitted </th>                    
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_totals as $user_total)                                                
                        <tr>
                            <td> {{ $user_total['representative_id'] }} </td>
                            <td> {{ $user_total['user_full_name'] }} </td>
                            <td> {{ $user_total['user_username'] }} </td>
                            <td> {{ $user_total['total_calls_by_user'] }} </td>
                            <td> {{ $user_total['total_positive_by_user'] }} </td>
                            <td> {{ $user_total['total_got_admitted_by_user'] }} </td>
                        </tr>
                    @endforeach    
                    {{-- @isset( $total_number_of_calls )
                    <tr class="">
                        <th class="text-center" colspan="2">Total</th>
                        <th>{{ $total_number_of_calls }}</th>
                        <th>{{ $total_positive }}</th>
                        <th>{{ $total_get_admitted }}</th>
                    </tr>         
                    @endisset          --}}
                </tbody>
            </table>
        </div>
    @else
        <h1> Database Empty !! Enter Some Data to Display Totals. </h1>
    @endisset    
@endsection
