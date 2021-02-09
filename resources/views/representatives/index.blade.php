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
            {{-- LATER
              <th>Edit</th>
              @endif 
            --}}                     
            @if (auth()->user()->isAdmin)
              <th>Delete</th>                                       
            @endif

            @if (!auth()->user()->isAdmin)
              <th> Roles </th>                                       
            @endif            
          </tr>
        </thead>
        <tbody>
          @foreach ($representatives as $representative)              
          <tr>            
              <td> {{ $representative->representative_id }} </td> 
              <td> {{-- <a href="{{ route('calls.display_for_user', $representative->representative_id) }}"> </a> --}} {{ $representative->name }} </td>
              <td> {{-- <a href="{{ route('calls.display_for_user', $representative->representative_id) }}"> </a> --}} {{ $representative->username }} </td>  
              
              {{-- LATER
                @if (auth()->user()->isAdmin)
                  <td> <a class="btn btn-info" href="{{ route('representatives.edit', $representative->representative_id) }}"> Edit </a> </td>                                                 
                @else
                  @if(auth()->user()->representative_id == $representative->representative_id)                
                    <td> <a class="btn btn-info" href="{{ route('representatives.edit', $representative->representative_id) }}"> Edit </a> </td>                    
                  @else
                    <td> <p class="btn btn-dark"> Not Your Account </p> </td>
                  @endif                  
                @endif 
              --}}
              @if (!auth()->user()->isAdmin)
                <th> 
                  @if($representative->isAdmin)
                  <li class="btn btn-dark"> Admin </li>
                  @else
                  <li class="btn btn-info"> User </li>
                  @endif </th>
              @endif            

              @if(auth()->user()->isAdmin)
                @if (auth()->user()->representative_id == $representative->id)
                  <td> <li class="btn btn-dark"> Cannot Delete Admin </li> </td>
                @else
                  <td> <a class="btn btn-danger" href="{{ route('representatives.delete', $representative->representative_id) }}"> Delete </a> </td>
                @endif
              {{-- @else
                @if(auth()->user()->representative_id != $representative->representative_id)
                  <td> <p class="btn btn-dark"> Not Your Account </p> </td>
                @else
                  <td> <li class="btn btn-dark"> Admin </li> </td>
                @endif --}}
              @endif
          </tr>                           
          @endforeach              
        </tbody>
      </table>
    </div>
</div>
@endsection
