<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //
    public function user(){
        Log::info('Displayung user.');
        return "Hello you are in user";
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
}
