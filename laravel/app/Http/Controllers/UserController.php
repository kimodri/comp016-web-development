<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function user(){
        return "Hello you are in user";
    }
    public function add($id){
        return "Hello you are in add with id:" . $id;
    }

    public function edit($id){
        return "Hello you are in edit with id:" . $id;
    }

    public function delete($id){
        return "Hello you are in delete with id:" . $id;
    }
}
