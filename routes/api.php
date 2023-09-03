<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ViewErrorBag;

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


Route::post('/login', function (Request $request) {
    $credentials = $request->only('name', 'password');

    if (!auth()->attempt($credentials)) {
        $errors = Session::get('errors', new ViewErrorBag);
        $errors->add('login', 'Invalid credentials');
        Session::flash('errors', $errors);
        return response(['message' => 'Invalid credentials'], 401);
    }

    $token = auth()->user()->createToken('api-token');

    return ['token' => $token->plainTextToken];
});


Route::middleware('auth:sanctum')->get('/beers', function (Request $request) {
    $client = new \GuzzleHttp\Client();
    $perPage = $request->get('per_page', 10);
    $page = $request->get('page', 1);
    $response = $client->get('https://api.punkapi.com/v2/beers', [
        'query' => [
            'page' => $page,
            'per_page' => $perPage, // Numero di birre per pagina
        ]
    ]);

    return response($response->getBody(), $response->getStatusCode());
});
