<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //
    public function user(){
        Log::info('Displayung user.');
        return view('userInfo');
    }
    public function add($id){
        Log::info('Adding user with id ' . $id);
        return "Hello you are in add with id:" . $id;
    }

    public function edit($id){
        Log::info('Editing user with id ' . $id);
        return "Hello you are in edit with id:" . $id;
    }

    public function delete($id){
        Log::info('Deleting user with id ' . $id);
        return "Hello you are in delete with id:" . $id;
    }

    public function userSubmit(Request $request){
        // dd($request->fname);
        $request->validate([
            'fname' => ['required', 'max:16'],
            'lname' => ['required', 'min:2'],
            'email' => ['required', 'email', 'ends_with:@microsoft.com'],
        ], [
            'fname.required' => 'Hello first name required!', 
            'lname.min' => "Bawal isa lang :)"
        ]);
        
        Log::info('Hello first name: ' . $request->fname);
        Log::info('Hello middle name: ' . $request->mname);
        Log::info('Hello last name: ' . $request->lname);
        Log::info('Hello email: ' . $request->email);
        Log::info('Hello password: ' . $request->password);

        DB::table('users')->insert([
            'fname'=>$request->fname,
            'mname'=>$request->mname,
            'lname'=>$request->lname,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)           
        ]);

        $users = DB::table('users')->get();
        
        Log::info('===============END USER SUBMIT============');
        
        return $users;

    }
}
