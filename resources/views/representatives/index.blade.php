@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">                          
    <table class="table table-striped">
        <thead>
          <tr>
            <th>Representative_ID</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Edit</th>
            @if(auth()->user()->isAdmin)            
              <th>Delete</th>            
            @endif
          </tr>
        </thead>
        <tbody>
          @foreach ($representatives as $representative)              
          <tr>            
              <td> {{ $representative->representative_id }} </td> 
              <td> <a href="{{ route('calls.display_for_user', $representative->representative_id) }}"> {{ $representative->name }} </a> </td>
              <td> <a href="{{ route('calls.display_for_user', $representative->representative_id) }}"> {{ $representative->username }} </a> </td>  
              
              @if (auth()->user()->isAdmin)
                <td> <a class="btn btn-info" href="{{ route('representatives.edit', $representative->representative_id) }}"> Edit </a> </td>                                                 
                @else
                  @if(auth()->user()->representative_id == $representative->representative_id)                
                  <td> <a class="btn btn-info" href="{{ route('representatives.edit', $representative->representative_id) }}"> Edit </a> </td>                    
                @else
                  <td> <p class="btn btn-dark"> Not Your Account </p> </td>
                @endif                  
              @endif

              @if (auth()->user()->isAdmin)
                <td> <a class="btn btn-danger" href="{{ route('representatives.delete', $representative->representative_id) }}"> Delete </a> </td>                                
              @endif              
          </tr>                           
          @endforeach              
        </tbody>
      </table>
    </div>
</div>
@endsection
