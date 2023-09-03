<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// routes/api.php

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (!auth()->attempt($credentials)) {
        return response(['message' => 'Invalid credentials'], 401);
    }

    $token = auth()->user()->createToken('api-token');

    return ['token' => $token->plainTextToken];
});


Route::middleware('auth:sanctum')->get('/beers', function (Request $request) {
    $client = new \GuzzleHttp\Client();
    $response = $client->get('https://api.punkapi.com/v2/beers', [
        'query' => [
            'page' => $request->get('page', 1),
            'per_page' => 10, // Numero di birre per pagina
        ]
    ]);

    return response($response->getBody(), $response->getStatusCode());
});
