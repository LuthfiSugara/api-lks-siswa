<?php

namespace App\Helper;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\models\User;

class userService {
    public $email, $password;

    public function __construct($email, $password){
        $this->email = $email;
        $this->password = $password;
    }

    public function validateInput(){
        $validator = Validator::make(['email' => $this->email, 'password' => $this->password],
            [
                'email' => ['required', 'email:rfc,dns', 'unique:users'],
                'password' => ['required', 'string', Password::min(6)]
            ]
        );

        if($validator->fails()){
            return ['status' => false, 'messages' => $validator->messages()];
        }else{
            return ['status' => true];
        }
    }

    public function register($deviceName){
        $validate = $this->validateInput();

        if($validate['status'] == false){
            return $validate;
        }else{
            $user = User::create([
                'name' => 'test',
                'email' => $this->email,
                'password' => Hash::make($this->password)
            ]);

            $token = $user->createToken($deviceName)->plainTextToken;
            return ['status' => true, 'token' => $token, 'user' => $user];
        }
    }

    public function login($deviceName){
        $validate = $this->validateInput();

        $user = User::where('email', $this->email)->first();
        if(!$user){
            return ['status' => false, 'messages' => 'User tidak terdaftar'];
        }else{
            if($user){
                $token = $user->createToken($deviceName)->plainTextToken;
                return ['status' => true, 'access_token' => $token, 'data' => $user];
            }else{
                return ['status' => false, 'messages' => 'Password Salah'];
            }
        }
    }
}
