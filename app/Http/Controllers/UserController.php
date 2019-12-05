<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request) {
        $username = $request->get('username');
        $password = $request->get('password');

        if ($this->checkIfUserExist($username)) {
            return response()->json([
                'message' => 'User already exist'
            ], 500);
        } else {
            $password = bcrypt($password);
            User::create([
                'username' => $username,
                'password' => $password
            ]);
            return response()->json(true);
        }
    }

    public function login(Request $request) {
        $username = $request->get('username');
        $password = $request->get('password');

        $user = $this->checkIfUserExist($username);

        if ($user) {
            $confirmPassword = Hash::check($password, $user->password);
            return response()->json([
                'status' => $confirmPassword,
                'token' => $user->authToken
            ]);
        } else {
            return response()->json([
                'message' => "Invalid credentials"
            ], 500);
        }
    }

    public function updateToken(Request $request) {
        $username = $request->get('uid');
        $token = $request->get('token');

        User::where('username', $username)->update([
            'authToken' => $token
        ]);
    }

    private function checkIfUserExist($username) {
        $user = User::where('username', $username)->first();

        if ($user) {
            return $user;
        } else {
            return false;
        }
    }
}
