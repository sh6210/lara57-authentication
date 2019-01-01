<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
//	return $request->all();
    return $request->user();
});

Route::middleware('auth:api')->get('/get-specific-user/{user}', function(\App\User $user){
	return \App\User::findOrFail($user);
});

Route::post('login', function(){
	if (auth()->attempt(['email' => request()->input('email'), 'password' => request()->input('password')])) {
		// Authentication passed...
		$user = auth()->user();
		$user->api_token = str_random(60);
		$user->save();
		return $user;
	}

	return response()->json([
		'error' => 'Unauthenticated user',
		'code' => 401,
	], 401);

});


