<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // return ro admin view
    public function index(){
        return view('admin.index');
    }


    // Handle request
    public function requestsPending(){

        // get all request
        $users =  Auth::all();
        dd($users);
    }

}
