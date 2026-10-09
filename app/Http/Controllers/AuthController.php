<?php

namespace App\Http\Controllers;

use App\Api\ApiResponse;
use App\Http\Requests\Auth\FormLogin;
use App\Http\Requests\Auth\FormRegister;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\FormResetPassword;


class AuthController extends Controller
{
    use ApiResponse;
   public function register(FormRegister $request)
   {
      $validated = $request->validated();
       $customer =Customer::create($validated);
       $customer->activeCart()->create();
      return $this->successResponse('User registered successfully', 201);
   }
   public function login(FormLogin $request)
   {
      $validated = $request->validated();
      $customer = Customer::where('email', $validated['email'])->first();
      if (!$customer || !Hash::check($validated['password'], $customer->password)) {
         return $this->errorResponse('Invalid credentials', 401);
      }
      $token = $customer->createToken('auth_token')->plainTextToken;
      return $this->successResponse([new CustomerResource($customer),
      "Authetication"=>['access_token' => $token, 'token_type' => 'Bearer']], 200);
   }
   public function logout(Request $request)
   {
      $request->user()->currentAccessToken()->delete();
      return $this->successResponse('Logged out successfully', 200);
   }
   public function changePassword(FormResetPassword $request)
   {
      $validated = $request->validated();
      $customer = Customer::where('email', $validated['email'])->first();
      if (!$customer || !Hash::check($validated['current_password'], $customer->password)) {
         return $this->errorResponse('Invalid credentials', 401);
      }
      $customer->password = Hash::make($validated['password']);
      $customer->save();
      return $this->successResponse(new CustomerResource($customer), 'Password reset successfully', 200);

   }
   
   


    
}
