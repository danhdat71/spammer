<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\SpamMessageController;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('test', function() {
    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', 'https://control.msg91.com/api/v5/flow/',
        [
            'body' => '{"template_id":"6425ab37d6fc056d4d406143","sender":"Shinhan","short_url":"0","mobiles":"84352026756","VAR1":"VALUE 1","VAR2":"VALUE 2"}',
            'headers' => [
                'accept' => 'application/json',
                'authkey' => '393675ATTmCOJKhWV6425aa30P1',
                'content-type' => 'application/json',
            ],
        ]
    );
      
    return $response->getBody();
});

Route::get('/', [AuthController::class, 'loginView']);
Route::post('login', [AuthController::class, 'login'])->middleware('throttle:login_limit');
Route::get('login', [AuthController::class, 'loginView']);
Route::post('face-login', [AuthController::class, 'faceLogin']);

Route::group([
    'prefix' => '',
    'middleware' => 'auth_user'
], function() {
    Route::get('dashboard', [DashBoardController::class, 'index']);    
    Route::get('customers', [CustomerController::class, 'index']);
    Route::delete('customers', [CustomerController::class, 'truncate']);
    Route::get('customers/{id}', [CustomerController::class, 'show']);
    Route::put('customers/{id}', [CustomerController::class, 'update']);
    Route::delete('customers/{id}', [CustomerController::class, 'delete']);
    Route::put('customers/{id}/status', [CustomerController::class, 'updateStatus']);
    Route::post('import-excel', [CustomerController::class, 'importExcel']);
    Route::put('spam-messages/{id}', [SpamMessageController::class, 'update']);
    Route::get('logout', [AuthController::class, 'logout']);
});

Route::get('get-user-paths', [AuthController::class, 'getUserPath']);
Route::get('models/{file_name}', [AuthController::class, 'getModels']);