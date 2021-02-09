<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Call;
use Illuminate\Support\Facades\Auth;

class RepresentativeController extends Controller
{
    public function index(){
        $representatives =  User::all()->sortBy('representative_id');       
        return view('representatives.index')->with('representatives', $representatives);
    }

    public function create(){
        if(Auth::user()->isAdmin){
            return view('representatives.create');
        }
        else{
            return redirect()->route('calls.index')->with('error', 'Access Denied !! Admin privilege is required.');
        }
    }

    public function store(Request $request){        

        if(Auth::user()->isAdmin){
            //validation
            $request->validate([
                'representative_id' => 'required|min:0|max:16777215|numeric|unique:users,representative_id',
                'name' => 'required|string|min:3|max:255',
                'username' => 'required|string|min:3|max:255|unique:users',
                'password' => 'required|string|min:8|max:255',
                'confirm_password' => 'required|string|min:8|max:255'
            ]);
                                
            $duplicate_user = User::where('representative_id', $request->representative)->first();
            $user_with_same_name = User::where('username', $request->username)->first();
            
            if( Auth::user()->isAdmin && isset($duplicate_user) ){
                return back()->with('error', 'A Representative with that ID already exists !!');            
            }

            if( Auth::user()->isAdmin && isset($user_with_same_name) ){
                return back()->with('error', 'A Representative with that Username already exists !!');            
            }

            if($request->password == $request->confirm_password){
                $user = new User();
                $user->representative_id = $request->representative_id;
                $user->name = $request->name;
                $user->username = $request->username;
                $user->password = bcrypt($request->password);
                $user->save();                

                return redirect()->route('representatives.create')->with('success', 'User Created Successfully !!');        
            }
            else{
                return redirect()->route('representatives.create')->with('error', 'Passwords Do Not Match !!');        
            }   
        }                
        else{
            return redirect()->route()->with('error', 'Access Denied !! Admin privilege is required.');
        }                     
    }    

    public function edit($representative_id){
        if(Auth::user()->isAdmin || Auth::user()->representative_id == $representative_id){
            $representative = User::where('representative_id', $representative_id)->first();               
            return view('representatives.edit')->with('representative', $representative);
        }
        else{
            return redirect()->route('calls.index')->with('error', 'Access Denied !! Admin privilege is required.');
        }        
    }

    public function update(Request $request){        
        if(Auth::user()->isAdmin || (Auth::user()->representative_id == $request->representative_id) ){               
            $request->validate([
                'representative_id' => 'required|min:1|max:16777215',
                'name' => 'required|string|min:3|max:255',                                  
            ]);                                    
            
            $duplicate_user = User::where('representative_id', $request->representative_id)->first();            
            if( Auth::user()->isAdmin && isset($duplicate_user) && ($request->id != $duplicate_user->id) ){
                return back()->with('error', 'A Representative with that ID already exists !!');            
            }            
            
            $user_with_same_name = User::where('username', $request->username)->first();
            if(isset($user_with_same_name) && ($request->id != $user_with_same_name->id) ){
                return back()->with('error', 'A Representative with that Username already exists !!');            
            }        
            
            $user = User::find($request->id);
            // Change the representative ids of all calls that were associated with this user so they can still have a relation between them
            Call::where('representative_id', '=', $user->representative_id)->update(['representative_id' => $request->representative_id]);
            $user->representative_id = $request->representative_id;
            $user->name = $request->name;            
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect()->route('representatives.index')->with('success', 'User Updated Successfully !!');       
        }
        else{
            return redirect()->route('calls.index')->with('error', 'Access Denied !! Admin privilege is required.');
        }        
    }

    public function delete($representative_id){
        $representative = User::where('representative_id', $representative_id)->first();
        if(!isset($representative)){
            return redirect()->route('representatives.index')->with('error', 'Representative with that ID doesn\'t exist !!');    
        }
        if(Auth::user()->isAdmin){
            if(!$representative->isAdmin){
                return view('representatives.delete')->with('representative', $representative);
            }else{
                return redirect()->route('representatives.index')->with('error', 'Cannot Delete Admin or Self !!');    
            }
        }
        else{
            return redirect()->route('representatives.index')->with('error', 'Access Denied !! Admin privilege is required.');
        }        
    }

    public function destroy($id){ 

        $representative = User::find($id);
        if(!isset($representative)){
            return redirect()->route('representatives.index')->with('error', 'Representative with that ID doesn\'t exist !!');    
        }        
        if(Auth::user()->isAdmin){
            if(!$representative->isAdmin){
                $representative->delete();
                return redirect()->route('representatives.index')->with('success', 'Representative Deleted Successfully !!');
            }else{
                return redirect()->route('representatives.index')->with('error', 'Cannot Delete Admin or Self !!');    
            }
        }
        else{
            return redirect()->route('calls.index')->with('error', 'Access Denied !! Admin privilege is required.');
        }
    }
}
