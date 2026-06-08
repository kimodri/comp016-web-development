<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function userDashboard(){
        // Get the users

        $users = DB::table('users')->get();
        $pageName = "dashboard";

        return view('users-dashboard', compact('users', 'pageName'));
    }

    public function editUser($id){
        $pageName = "editUser";
        return view('edit-user', compact('id', 'pageName'));
    }

    public function submitEdit(Request $request, $id){
        // get the info of the user with the id id
        $user = DB::table('users')->where('id', $id)->update([
            'email'=> $request->email,
            'fname'=> $request->fname,
            'mname'=> $request->mname,
            'lname'=> $request->lname,
            'password'=> Hash::make($request->password),
        ]);

        return redirect()->route('getUsers');
    }
}
