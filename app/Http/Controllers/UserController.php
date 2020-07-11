<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{

    public function getUsers()
    {
        $users = User::all();

        if ($users) {
            return response()->json([
                'success' => true,
                'data' => $users
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Users have not found'
            ], 404);
        }
    }

    public function getUserById($id)
    {
        $user = User::firstWhere('id', $id);

        if ($user) {
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch user'
            ], 404);
        }
    }

    public function createUser(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email|unique:users',
                'name' => 'required',
                'password' => 'required|min:6'
            ]
        );

        $data = [
            'id' => md5(uniqid('usr', true)),
            'name' =>  $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'api_token' => ''
        ];


        $register = User::create($data);

        if ($register) {
            return response()->json([
                'success' => true,
                'message' => 'User has been created!',
                'data' => $register
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to creating user',
                'data' => $register
            ], 400);
        }
    }

    public function updateUser(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email|unique:users',
                'name' => 'required',
                'password' => 'required|min:6'
            ]
        );

        $user = User::where('id', $id);
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if ($user->update($data)) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully!'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user',
            ], 400);
        }
    }

    public function deleteUser($id)
    {
        $user = User::firstWhere('id', $id);

        if ($user->delete()) {
            return response()->json([
                'success' => true,
                'message' => "User '$user[name]' has been deleted",
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user'
            ], 400);
        }
    }
}
