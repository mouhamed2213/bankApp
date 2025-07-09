<?php

namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class CompteBancaireController extends Controller
{

    // store bank information
    public function store (Request $request) {
        dd($request);
    }
}
