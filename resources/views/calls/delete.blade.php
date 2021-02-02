@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">                                    
        <div class="card text-center" style="width: 70rem;">
            <div class="card-body">
                <h1>Are You Sure You Want to Delete the Following Call Entry ??</h1>
                
                <ul class="list-group list-group-flush">                    
                    <h5> <li class="list-group-item"> Representative ID: {{ $call->representative_id }}</li> </h5>
                    <h5> <li class="list-group-item"> Name: {{ $call->user->name }}</li> </h5>
                    <h5> <li class="list-group-item"> No. of Calls: {{ $call->number_of_calls }} </li> </h5>
                    <h5> <li class="list-group-item"> Positive:{{ $call->positive }} </li> </h5>                    
                    <h5> <li class="list-group-item"> Got Admitted:{{ $call->get_admitted }} </li> </h5>
                    <h5> <li class="list-group-item"> Created At:{{ $call->created_at }} </li> </h5>
                </ul>

                <div class="d-flex flex-row justify-content-center">
                    
                    <form type="hidden" action="{{ route('calls.destroy', $call->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-3 py-2"> Yes </button>
                    </form>                    

                    <a href="{{ route('calls.index') }}" class="btn btn-primary px-3 py-2 mx-2">No</a>    
                </div>                
            </div>
        </div>

    </div>
</div>
@endsection
