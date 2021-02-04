@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">                            

        <div class="card text-center" style="width: 70rem;">
            <div class="card-body">
                <h1>Are You Sure You Want to Delete the Following Representative ??</h1>
                
                <ul class="list-group list-group-flush">                    
                    <h5> <li class="list-group-item"> Representative ID: {{ $representative->representative_id }} </li> </h5>
                    <h5> <li class="list-group-item"> Representative Name: {{ $representative->name }} </li> </h5>                                        
                </ul>

                <div class="d-flex flex-row justify-content-center">
                    
                    <form type="hidden" action="{{ route('representatives.destroy', $representative->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-3 py-2"> Yes </button>
                    </form>                    

                    <a href="{{ route('representatives.index') }}" class="btn btn-primary px-3 py-2 mx-2">No</a>    
                </div>                
            </div>
        </div>

    </div>
</div>
@endsection
