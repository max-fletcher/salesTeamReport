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
            return view('calls.create')->with('representative', $representative);
        }
        
    }

    public function store(Request $request){        
        //validation                        
        $request->validate([
            'representative_id' => 'required',
            'number_of_calls' => 'required|integer|min:0',            
            'positive' => 'required|integer|min:0',            
            'got_admitted' => 'required|integer|min:0',                        
        ]);

        if(Auth::user()->isAdmin || Auth::user()->representative_id == $request->representative_id){
            if( ($request->number_of_calls > $request->positive) && ($request->number_of_calls > $request->got_admitted) ){
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
        if(Auth::user()->isAdmin || Auth::user()->representative_id == $call->representative_id){
            return view('calls.edit')->with('call', $call);
        }
        else{
            return redirect()->route('calls.index')->with('error', 'Access Denied !! Not Your Entry.');
        }
    }

    public function update(Request $request){
        //validation 
        // dump($request->call_id);
        $call = Call::where('id', $request->call_id)->first();
        // dd($call->representative_id);        

        if(Auth::user()->isAdmin ||  Auth::user()->representative_id == $call->representative_id){            
            $request->validate([            
                'number_of_calls' => 'required|integer|min:0', 
                'positive' => 'required|integer|min:0',            
                'got_admitted' => 'required|integer|min:0',
            ]);                 
    
            if( ($request->number_of_calls > $request->positive) && ($request->number_of_calls > $request->got_admitted) ){
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
        if(Auth::user()->isAdmin || Auth::user()->representative_id == $call->representative_id){
            return view('calls.delete')->with('call', $call);
        }
        else{
            return redirect()->route('calls.index')->with('error', 'Access Denied !! Not Your Entry.');
        }        
    }

    public function destroy($id){
        $call = Call::find($id);
        if(Auth::user()->isAdmin || Auth::user()->representative_id == $call->representative_id){
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
        
        $searchfromdate = Carbon::createFromFormat('d/m/Y', $request->fromdate);
        $searchtodate = Carbon::createFromFormat('d/m/Y', $request->todate);
                
        if( $searchfromdate <= $searchtodate ){ 
            $searchfromdate = Carbon::parse($searchfromdate)->StartOfDay()->format('Y-m-d H:i:s');
            $searchtodate = Carbon::parse($searchtodate)->endOfDay()->format('Y-m-d  H:i:s');
            $calls = Call::where('representative_id', $request->representative_id)->whereBetween('created_at', [$searchfromdate, $searchtodate])->get();            
            $total_number_of_calls = $calls->sum('number_of_calls');               
            $total_positive = $calls->sum('positive');               
            $total_get_admitted = $calls->sum('get_admitted');                        

            return view('calls.results_of_summary')
            ->with('calls', $calls)            
            ->with('total_number_of_calls', $total_number_of_calls)
            ->with('total_positive', $total_positive)
            ->with('total_get_admitted', $total_get_admitted);
        }               
        if( $searchfromdate > $searchtodate){
            return view('calls.results_of_summary');
        }        
    }

    public function retrieve_summary_without_users(Request $request){                                          

        $request->validate([            
            'fromdate' => 'required',            
            'todate' => 'required',            
        ]);                                
        
        $searchfromdate = Carbon::createFromFormat('d/m/Y', $request->fromdate);
        $searchtodate = Carbon::createFromFormat('d/m/Y', $request->todate);   
        
        if( $searchfromdate <= $searchtodate ){                         
            $searchfromdate = Carbon::parse($searchfromdate)->StartOfDay()->format('Y-m-d H:i:s');
            $searchtodate = Carbon::parse($searchtodate)->endOfDay()->format('Y-m-d  H:i:s');               
            $calls = Call::whereBetween('created_at', [$searchfromdate, $searchtodate])->get();            
            $total_number_of_calls = $calls->sum('number_of_calls');               
            $total_positive = $calls->sum('positive');               
            $total_get_admitted = $calls->sum('get_admitted');                         

            return view('calls.results_of_summary')
            ->with('calls', $calls)            
            ->with('total_number_of_calls', $total_number_of_calls)
            ->with('total_positive', $total_positive)
            ->with('total_get_admitted', $total_get_admitted);
        }                
        if( $searchfromdate > $searchtodate ){            
            return view('calls.results_of_summary');                
        }       
    }

    public function find_total_for_each_user(){        
        return view('calls.total_for_each_user_within_dates');
    }

    public function calculate_total_for_each_user(Request $request){                                          

        $request->validate([            
            'fromdate' => 'required',            
            'todate' => 'required',            
        ]);             
        
        $all_representatives = User::all();
                
        $searchfromdate = Carbon::createFromFormat('d/m/Y', $request->fromdate);
        $searchtodate = Carbon::createFromFormat('d/m/Y', $request->todate);        
        
        if( $searchfromdate <= $searchtodate ){                
            $searchfromdate = Carbon::parse($searchfromdate)->StartOfDay()->format('Y-m-d H:i:s');
            $searchtodate = Carbon::parse($searchtodate)->endOfDay()->format('Y-m-d  H:i:s');
            
            $user_totals = collect();

            foreach($all_representatives as $representative){                         
                $all_calls_by_user = Call::with('user')->where('representative_id',$representative->representative_id)
                ->whereBetween('created_at', [$searchfromdate, $searchtodate])->get();                                
                $total_calls_by_user = $all_calls_by_user->sum('number_of_calls');
                $total_positive_by_user = $all_calls_by_user->sum('positive');
                $total_got_admitted_by_user = $all_calls_by_user->sum('get_admitted');                
                $user_totals->push([
                    'representative_id' => $representative->representative_id,
                    'user_full_name' => $representative->name,                                        
                    'user_username' => $representative->username,
                    'total_calls_by_user' => $total_calls_by_user,
                    'total_positive_by_user' => $total_positive_by_user,
                    'total_got_admitted_by_user' => $total_positive_by_user,                    
                ]);                
            }  
            
            $user_totals = $user_totals->toArray();

            return view('calls.display_total_for_each_user')
            ->with('user_totals', $user_totals)
            ->with('fromdate', $request->fromdate)
            ->with('todate', $request->todate);
        }        

        if( $searchfromdate > $searchtodate ){
            return view('calls.display_total_for_each_user');
        }       
    }

    public function display_total_for_each_user(){

    }    
}
