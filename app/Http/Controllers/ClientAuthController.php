<?php

use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller {
          public function clientLogin(Request $request)
          {
              $request->validate([
                  'email' => 'required|string|email',
                  'password' => 'required|string',
              ]);
          
              $client = Client::where('email', $request->email)->first();
          
              if (!$client || !Hash::check($request->password, $client->password)) {
                  return response()->json(['message' => 'Unauthorized'], 401);
              }
          
              $token = $client->createToken('API Token', ['client'])->plainTextToken;
          
              return response()->json([
                  'accessToken' => $token,
                  'token_type' => 'Bearer',
                  'user' => $client
              ]);
          }
}
