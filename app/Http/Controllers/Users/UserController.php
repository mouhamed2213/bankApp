<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Compte\CompteBancaireController;
use App\Models\Compte\CompteBancaire;
use App\Models\compte\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{        private int  $userID;


    // return to view index
    public function index(){
        $userId = Auth::user()->id;

        return  view('user.index');
    }

}
