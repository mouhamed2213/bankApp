<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compte\CompteBancaire;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // return ro admin view
    public function index(){
        return view('admin.index');
    }


    // Handle request
    public function requestsPending(){
        // get all user with account statut = en attente
        $userAccounstRequester = CompteBancaire::with('user')->where('status', 'en attente')->get();
            return view('admin.requests',compact('userAccounstRequester'));
    }


//    Show one infomation acccount
    public function show($id){
        $userRequestInfo = CompteBancaire::with('user')->where('id', $id)->findOrFail($id);
            return view('compte.show', compact('userRequestInfo'));
    }


    // the user account is accepted
    public function validated($id){

        // update the state of the account state
            $update = CompteBancaire::findOrFail($id);
            $update -> status ="active";
//            $update -> save();
            return redirect()->route('requests.requestsPending')->with('user account active with success');
    }

    // rejected account
    public function rejected($id){

        // update the state of the account state
            $update = CompteBancaire::findOrFail($id);
            $update -> status ="rejected";
            $update -> save();
            return redirect()->route('requests.requestsPending')->with('deleted successed');
    }



}

