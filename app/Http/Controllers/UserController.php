<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function register(Request $request) {

        $res = $this->microgen->auth->register($request->all());

        if (array_key_exists('error', $res)) {
            return response()->json($res['error'], $res['status']);
        };

        $user = User::create(array(
            'id' => $res['user']['_id'],
            'firstName' => $res['user']['firstName'],
            'lastName' => $res['user']['lastName'],
            'email' => $res['user']['email'],
            'phoneNumber' => $res['user']['phoneNumber'],
        ));

        return response()->json($user);
    }

    public function login(Request $request) {

        $res = $this->microgen->auth->login($request->all());

        if (array_key_exists('error', $res)) {
            return response()->json($res['error'], $res['status']);
        };

        $user = User::where('email', $request->email)->first();

        return response()->json($user);
    }
}
