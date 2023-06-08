<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    UserController
};
use App\Http\Middleware\{AdminMiddleware};

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


Route::prefix('v1')->group(function () {


    /// Declare the heartbeat route for the API
    Route::any('/', function () {
        return response()->json(['message' => 'Welcome to Elite Homes API'], 200);
    });

    // Declare register route
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Declare login route
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    //Protected routes for authenticated users
    Route::group(['middleware'  => ['auth:api']], static function () {

        // All Admin routes should be declared here
        Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function () {
            Route::apiResource('/users', UserController::class)->name('Admin', 'Users');
        });
    });
});
