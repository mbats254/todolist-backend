<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public $successStatus = 200;/**
    * login api
    *
    * @return \Illuminate\Http\Response
    */

    public function register(Request $request)
    {
        $response = $request->all();
        // dd($response);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
                    return response()->json(['error'=>$validator->errors()], 400);
        }
        $user = User::where('email','=',$response['email'])->get()->toArray();
        if (count($user) > 0) {
            return response()->json(["error"=>'user exists'],400); //exists
        }else {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => $input['password'],
                'uniqid' => uniqid(),
                'role' => 'customer'
            ]);
            $success['token'] =  $user->createToken('Todo')->accessToken;
            $success['name'] =  $user->name;
            $success['email'] = $user->email;
            if($user) {
                $user->sendEmailVerificationNotification();
                // $user->notify(new VerifyEmail($user));
                return response()->json(['success'=>$success], $this->successStatus);
            } else {
                return response()->json(['error'=> "User not found"],400);
            }
        }
    }

    public function login(Request $request) {
        $response = $request->all();
        $user = User::where('email','=',$request->email)->get()->toArray();
        if (count($user) > 0) {
             if(Auth::attempt(['email' => $response['email'], 'password' => $response['password']])){
                $user = Auth::user();
                $success['token'] =  $user->createToken('Todo')->accessToken;
                $success['name'] =  $user->name;
                $success['email'] = $user->email;
                $success['uniqid'] = $user->uniqid;

                if($user->role == 'admin')
                {
                    // Auth::login($user);
                   return redirect('/');
                }

                // $success['timestamp'] = date('Y-m-d H:i:s');
                return response()->json(['success' => $success], $this->successStatus);
            }
            else{
                return response()->json(['error'=> "Email_or_password_wrong" ],400); //Error
            }
        } else {
            return response()->json(['success'=>"User_does_not_exist"],400); //Does Not exist
        }
    }

    public function api_error(Request $request)
    {
        return response()->json(['error'=>'Login and Pass Key'], 400);
    }

    public function all_users(Request $request)
    {
        $users = User::where('role','!=','admin')->where('organisation_id','=',null)->get();
        // $users = User::get();
        return response()->json([$users]);
    }
}
