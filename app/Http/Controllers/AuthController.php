<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
	public function register(Request $request)
	{
		try {
			$validate = Validator::make(
				$request->all(),
				[
					'username' => ['required'],
					'mobile' => ['required', 'unique:users,mobile', 'digits:10'],
					'password' => ['required', 'confirmed'],
				],
				
			);
			if ($validate->fails()) {
				return response()->json([
					'status' => false,
					'data' => [],
					'message' => $validate->errors()
				], 401);
			}

			$user = User::create([
				'username' => $request->username,
				'mobile' => $request->mobile,
				'password' => Hash::make($request->password)
			]);
			$token = $user->createToken($request->password)->plainTextToken;

			$data = [];
			$data['user'] = $user;
			$data['token'] = $token;

			return response()->json([
				'status' => 'true',
				'data' => $data,
				'message' => 'User Registered Successfully'
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 'false',
				'data' => [],
				'message' => $e->getMessage()
			], 500);
		}
	}

	public function login(Request $request)
	{
		try {
			$validate = Validator::make(
				$request->all(),
				[
					'mobile' => ['required', 'string', 'digits:10', 'exists:users,mobile'],
					'password' => ['required', 'confirmed',],
				]
			);

			if ($validate->fails()) {
				return response()->json([
					'status' => false,
					'data' => [],
					'message' => $validate->errors()
				], 401);
			}

			if (!Auth::attempt($request->only('mobile', 'password'))) {
				return response()->json([
					'status' => 'false',
					'data' => [],
					'message' => 'Mobile & Password does not match with our record.',
				]);
			}

			$user = User::where('mobile', '=', $request->mobile)->first();
			$token = $user->createToken($request->password)->plainTextToken;
			$data = [];
			$data['token'] = $token;
			$data['user'] = $user;

			return response()->json([
				'status' => 'true',
				'data' => $data,
				'message' => 'User Logged in Successfully'
			], 200);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 'false',
				'data' => [],
				'message' => $e->getMessage()
			], 500);
		}
	}
	
	public function logout(){
		Auth::user()->currentAccessToken()->delete();
		return response()->json([
			'status' => true,
			'data' => [],
			'message' => 'User Logged out Successfully'
		]);
	}
}
