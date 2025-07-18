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
}

