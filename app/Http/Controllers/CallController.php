<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Call;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CallController extends Controller
{
    public function index(){
        $calls = Call::all()->sortByDesc('created_at');
        return view('calls.index')->with('calls', $calls);
    }

    public function create(){
        // return all rep_id to select from if authenticated user is an admin. (else) If authenticated user is not an admin, send only his own rep_id and he can't select any other.
        if(Auth::user()->isAdmin){
            $representatives = User::all();
        return view('calls.create')->with('representatives', $representatives);
        }
        else{
            $representative = Auth::user();
            //dd($representatives);
            return view('calls.create')->with('representative', $representative);
        }
        
    }

    public function store(Request $request){        
        //validation                        
        $request->validate([
            'representative_id' => 'required',
            'number_of_calls' => 'required|integer|min:1',            
            'positive' => 'required|integer|min:1',            
            'got_admitted' => 'required|integer|min:1',                        
        ]);

        if(Auth::user()->isAdmin || Auth::user()->representative_id == $request->representative_id){
            if( ($request->number_of_calls > $request->positive) && ($request->number_of_calls > $request->get_admitted) ){
                $call_entry = new Call();
                $call_entry->representative_id = $request->representative_id;
                $call_entry->number_of_calls = $request->number_of_calls;
                $call_entry->positive = $request->positive;
                $call_entry->get_admitted = $request->got_admitted;
                $call_entry->save();
    
                return redirect()->route('calls.create')->with('success', 'Call Entry Created Successfully !!');
            }
            else{            
                return redirect()->route('calls.create')->with('error', 'Some of the Data Provided is Incoherent ! Please Re-enter !!');
            }
        }
        else{
            return redirect()->route('calls.create')->with('error', 'Access Denied !! Your Representative ID Does Not Match !!');
        }

                
    }

    public function edit($id){
        $call = Call::where('id', $id)->with('user')->first();
        if(Auth::user()->representative_id == $call->representative_id){
            return view('calls.edit')->with('call', $call);
        }
        else{
            return redirect()->route('calls.index')->with('error', 'Access Denied !! Not Your Entry.');
        }
    }

    public function update(Request $request){
        //validation 
        
        if(Auth::user()->representative_id == $call->representative_id){            
            $request->validate([            
                'number_of_calls' => 'required|integer|min:1', 
                'positive' => 'required|integer|min:1',            
                'got_admitted' => 'required|integer|min:1',
            ]);                 
    
            if( ($request->number_of_calls > $request->positive) && ($request->number_of_calls > $request->get_admitted) ){
                $call_entry = Call::find($request->call_id);
                $call_entry->representative_id = $request->representative_id;
                $call_entry->number_of_calls = $request->number_of_calls;
                $call_entry->positive = $request->positive;
                $call_entry->get_admitted = $request->got_admitted;
                $call_entry->save();
    
                return redirect()->route('calls.index')->with('success', 'Call Entry Created Successfully !!');
            }
            else{            
                return redirect()->route('calls.index')->with('error', 'Some of the Data Provided is Incoherent ! Please Re-enter !!');
            }
        }
        else{
            return redirect()->route('calls.index')->with('error', 'Access Denied !! Not Your Entry.');
        }        
    }

    public function delete($id){
        $call = Call::where('id', $id)->with('user')->first();        
        if(Auth::user()->representative_id == $call->representative_id){
            return view('calls.delete')->with('call', $call);
        }
        else{
            return redirect()->route('calls.index')->with('error', 'Access Denied !! Not Your Entry.');
        }        
    }

    public function destroy($id){
        $call = Call::find($id);
        if(Auth::user()->representative_id == $call->representative_id){
            $call->delete();   
            return redirect()->route('calls.index');
        }
        else{
            return redirect()->route('calls.index')->with('error', 'Access Denied !! Not Your Entry.');
        }        
    }

    public function display_for_user($representative_id){
        $calls = Call::where('representative_id',$representative_id )->get();
        return view('calls.display_for_user')->with('calls', $calls);
    }

    public function generate_summary_with_users(){
        $all_representatives = User::all();
        return view('calls.generate_summary_with_users')->with('all_representatives', $all_representatives);
    }

    public function generate_summary_without_users(){
        $all_representatives = User::all();
        return view('calls.generate_summary_without_users')->with('all_representatives', $all_representatives);
    }

    public function retrieve_summary_with_users(Request $request){                               

        $request->validate([            
            'fromdate' => 'required',            
            'todate' => 'required',
            'representative_id' => 'required'
        ]);     
        
        $all_representatives = User::all();
        
        $searchfromdate = Carbon::parse($request->fromdate)->subDay()->endOfDay()->format('Y-m-d');
        $searchtodate = Carbon::parse($request->todate)->endOfDay()->format('Y-m-d');        
        
        if( $searchfromdate < $searchtodate ){                
            $calls = Call::where('representative_id', $request->representative_id)->whereBetween('created_at', [$searchfromdate, $searchtodate])->get();
            return view('calls.generate_summary_with_users')->with('calls', $calls)->with('all_representatives', $all_representatives);
        }        
        else{                        
            return view('calls.generate_summary_with_users')->with('error', 'The From Date has to be less the To Date !! ');                
        }        
    }

    public function retrieve_summary_without_users(Request $request){                                          

        $request->validate([            
            'fromdate' => 'required',            
            'todate' => 'required',            
        ]);     
        
        $all_representatives = User::all();
        
        $searchfromdate = Carbon::parse($request->fromdate)->subDay()->endOfDay()->format('Y-m-d');
        $searchtodate = Carbon::parse($request->todate)->endOfDay()->format('Y-m-d');
                                    
        if( $searchfromdate < $searchtodate ){                
            $calls = Call::whereBetween('created_at', [$searchfromdate, $searchtodate])->get();
            return view('calls.generate_summary_without_users')->with('calls', $calls)->with('all_representatives', $all_representatives);
        }        
        else{                        
            return view('calls.generate_summary_without_users')->with('error', 'The From Date has to be less the To Date !! ');    
        }       
        
    }
}
