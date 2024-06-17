<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
        /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:la_users',
            'password' => 'required|string',
            'c_password' => 'required|same:password'
        ]);

        $user = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($user->save()) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'message' => 'Successfully created user!',
                'accessToken' => $token,
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $user = $request->user();
        // $permissions = $user->getPermissionsViaRoles()->pluck('name');
        // $user->unsetRelation('roles');
        // $data = array_merge($user->attributesToArray(), ['permissions' => $permissions]);
        return response()->json($user);
    }


    public function user_update(Request $request)
    {
        $user = $request->user();
        if ($user != null) {

            $u =  User::where('id', $user->id)->first();

            if ($request->name  != null) {
                $u->name = $request->name;
            }
            if ($request->phone  != null) {
                $u->phone = $request->phone;
            }

            $u->save();
        }
        return response()->json($request->user());
    }


    public function logout(Request $request)
    {

        Auth::guard('web')->logout();

        Auth::user()->tokens()->delete(); // Revoke all tokens associated with the user

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
