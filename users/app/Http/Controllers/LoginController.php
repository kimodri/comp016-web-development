<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function getLogin(){
        return view('login');
    }

    public function postLogin(Request $request){
        Log::info('called!');
        $request->validate([
            'fname' => ['required', 'max:16'],
            'lname' => ['required', 'min:2'],
            'email' => ['required', 'email', 'endswith:@gmail.com']
        ],
        [
            'fname.required' => 'First name is required!'
        ]);

        DB::table('users')->insert(
            [
                'fname'=> $request->fname,
                'mname'=> $request->mname,
                'lname'=> $request->lname,
                'email'=> $request->email,
                'password'=> Hash::make($request->password),
            ]
        );

        $users = DB::table('users')->get();
        
        Log::info('===============END USER SUBMIT============');
        
        return redirect()->route('login');
    }
}
