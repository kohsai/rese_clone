<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
   public function register()
   {
    return view('register');
   }

   public function thanks()
   {
      return view('thanks');
   }

   public function store(RegisterRequest $request)
   {
      $validatedData = $request->validated();

      $user = User::create([
         'name'  => $validatedData['name'],
         'email' => $validatedData['email'],
         'password' => Hash::make($validatedData['password']),
      ]);

      return redirect()->route('thanks');
   }
}


