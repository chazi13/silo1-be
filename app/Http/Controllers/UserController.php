<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array("errors" => $validator->errors()), 400);
        };

        $user = User::create($request->all());

        return response()->json($user);
    }
}
