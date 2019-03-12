<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class UserController extends Controller
{
    //SIGNUP
    public function signup(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);


         //CREATE USER
    $user = new User([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => bcrypt($request->input('password'))
    ]);

    $user->save();

    //RETURN RESPONSE
    return response()->json([
        'message' => 'User has been created',
        'success' => true
    ], 201);
    
 }//END SIGN UP

 //LOGIN USER
 public function signin(Request $request){
    $this->validate($request, [
        
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $credentials = $request->only('email', 'password');

    try {
        if(!$token = JWTAuth::attempt($credentials)){
            return response()->json([
                'error' => 'Invalid Credentials'
            ], 401);
        }
        
    } catch(JWTException $e) {
        return response()->json([
            'error' => 'Could not create token'
        ], 500);

    }
    return response()->json([
        'token' => $token,
        'loginSuccess' => true
    ], 200);


 }//END SIGN IN

 /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

}

   
