<?php

namespace App\Http\Controllers\Auth;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Sub_Domain;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email|string|max:255|exists:users,email',
            'password' => 'string|required'
        ]);

        if (Auth::attempt($credentials)){
            if (Auth::user()->getRole->role_name == 'Admin'){
                return redirect()->route('menuIndex');
            } else if (Auth::user()->getRole->role_name == 'Super Admin'){
                return redirect()->route('superAdminIndex');
            }
        }else{
            return redirect()->back();
        }

    }







}

