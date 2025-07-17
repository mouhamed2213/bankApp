<?php

namespace App\Http\Controllers\virtualCard;

use App\Http\Controllers\Controller;
use App\Models\Compte\CompteBancaire;
use App\Service\VirtualCardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VirtualCardController extends Controller
{
    //-----------
    public function index(){
        return view('virtualCard.index');
    }

    public function create(){
        $userId  =  Auth::user()->id;
        $userAccountNumber = CompteBancaire::where('user_id', $userId)
            ->where('status','active')
            ->pluck('numero_compte'); // get only the selected colone
        return view('virtualCard.create', compact('userAccountNumber'));}

    // Store the bank account virtual card
    public function store(Request $request){
        $seletedAccount = $request -> input('choosedAccount');
        if(VirtualCardService::generateVirtualCard($seletedAccount)){
            session(['hasBankCard'  =>  false]);
        }
        return redirect()->route('virtualCard.index')->with("card craeted successfully");
    }
}



