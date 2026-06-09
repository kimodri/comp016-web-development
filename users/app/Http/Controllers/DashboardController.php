<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function userDashboard(){
        // Get the users

        $users = DB::table('users')
                ->leftJoin('user_types', 'users.user_type', '=', 'user_types.id')
                ->select('users.*', 'user_types.display_name')
                ->get();
        $pageName = "dashboard";

        return view('users-dashboard', compact('users', 'pageName'));
    }

    public function editUser($id){
        $pageName = "editUser";
        $user = DB::table('users')->find($id);
        $user_types = DB::table('user_types')->get();
        return view('edit-user', compact('id', 'pageName', 'user', 'user_types'));
    }

    public function submitEdit(Request $request, $id){
        // get the info of the user with the id id
        DB::table('users')->where('id', $id)->update([
            'email'=> $request->email,
            'fname'=> $request->fname,
            'mname'=> $request->mname,
            'lname'=> $request->lname,
            'user_type'=> $request->usertype,
            'password'=> Hash::make($request->password),
        ]);

        return redirect()->route('getUsers');
    }
}
