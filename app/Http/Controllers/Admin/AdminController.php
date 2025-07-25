<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compte\CompteBancaire;
use App\Models\compte\Transaction;
use App\Models\Demande;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // return ro admin view
    public function index(){
        $totalUser = User::all()->count();
        $totalCompte = CompteBancaire::all()->count();
        $totalDemande = Demande::all()->count();
        $totalTransaction = Transaction::all()->count();


        // get all user with account statut = en attente
        $userAccounstRequester =  Demande::with('comptes');



        return view('admin.index', [
            'totalUser' => $totalUser
            ,'totalCompte' => $totalCompte
            ,'totalDemande' => $totalDemande
            ,'totalTransaction' => $totalTransaction
            ,'userAccounstRequester' => $userAccounstRequester


        ]);
    }
}

