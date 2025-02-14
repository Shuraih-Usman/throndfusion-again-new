<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminAjax;
use App\Http\Controllers\UserAjax;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class,'index'])->name('home');
Route::get('/service/{id}', [MainController::class,'serviceView']);
Route::get('/services', [MainController::class,'ServicePage']);
Route::get('/search', [MainController::class,'SearchService']);
Route::get('/campaign/{id}', [MainController::class,'campaignView']);
Route::get('/category/{id}', [MainController::class,'Cats']);
Route::get('/account/{username}', [MainController::class,'Account']);
Route::get('/creator-reviews/{id}', [MainController::class,'Review']);

Route::prefix('/admin')->namespace('App\Http\Controllers\AdminController')->group(function() {
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });
    Route::get('login', [ AdminController::class, 'loginPage'])->name('admin.login');
    Route::post('login', [AdminAjax::class, 'handleLogin']);
    Route::get('logout', [AdminAjax::class, 'handleLogout'])->name('admin.logout');
    Route::group(['middleware' => ['admin']], function() {
        Route::get('/add-user', [AdminController::class, 'addUser'])->name('admin.add-user');
        Route::get('/users', [AdminController::class, 'Users'])->name('admin.users');
        Route::get('/edit-user/{id}', [AdminController::class, 'editUser'])->name('admin.edit-user');
        Route::get('/profile', [AdminController::class, 'Profile'])->name('admin.profile');
        Route::get('/edit-profile', [AdminController::class, 'editProfile'])->name('admin.edit-profile');
        Route::get('/edit-password', [AdminController::class, 'editPass'])->name('admin.edit-password');
        Route::get('/campaign-type', [AdminController::class, 'Campaign_type'])->name('admin.campaign_type');
        Route::get('/service-category', [AdminController::class, 'serviceCats'])->name('admin.service-cats');
        Route::get('/services', [AdminController::class, 'Services'])->name('admin.services');
        Route::get('/enroll-services', [AdminController::class, 'Enrollservices'])->name('admin.enrollservices');
        Route::get('/donation', [AdminController::class, 'Donation'])->name('admin.donation');
        Route::get('/investment', [AdminController::class, 'Investment'])->name('admin.investment');
        Route::get('/campaigns', [AdminController::class, 'Campaigns'])->name('admin.campaigns');
        Route::get('/wishlists-category', [AdminController::class, 'wishlistsCats'])->name('admin.wish_cats');
        Route::get('/wishes-items', [AdminController::class, 'wishesItems'])->name('admin.wish_items');
        Route::get('/withdrawal-requests', [AdminController::class, 'WithdrawalRequests'])->name('admin.withd-re');
        Route::get('/transactions', [AdminController::class, 'Transactions'])->name('admin.transactions');
        Route::get('/payments', [AdminController::class, 'Payments'])->name('admin.payments');
        Route::get('/activities', [AdminController::class, 'Activity'])->name('admin.activities');
        Route::get('/reviews', [AdminController::class, 'Review'])->name('admin.reviews');
        Route::get('/context-category', [AdminController::class, 'Context_cats'])->name('admin.ct');
        Route::get('/contexts', [AdminController::class, 'Contexts'])->name('admin.contexts');
        Route::get('/dashboard', [AdminController::class, 'Dashboard'])->name('admin.dashboard');
        Route::get('/', function() {
            return redirect(route('admin.dashboard'));
        });
        Route::match(['get', 'post'], '/ajax',[AdminAjax::class, 'Ajax']);
        Route::match(['get', 'post'], '/{modelname}/process',[AdminAjax::class, 'index']);
        
    });
});

Route::get('/login', [UserController::class, 'loginPage'])->name('login');
Route::get('/register', [UserController::class, 'Register'])->name('register');
Route::post('/login', [UserAjax::class, 'handleLogin']);
Route::get('/logout', [UserAjax::class, 'Logout'])->name('logout');
Route::match(['get', 'post'], '/main/{log}', [MainController::class,'log']);

Route::middleware(['auth'])->group(function() {
    Route::match(['get', 'post'], '/ajax/{type}', [MainController::class,'ajax']);
    Route::match(['get', 'post'], '/reference', function (Request $request) {
        $monnify = new \App\Http\Controllers\Payment\Monnify();
        $s = 0;
        $m = "";
        $reference = $_GET['reference'];
        $verify = $monnify->verifyTrans($reference);
        
        var_dump($verify);

        // if($verify['paymentStatus'] == 'PAID'){

        //     $payment = new \App\Models\MainModel\Payment;
        //     $pay = $payment::where('reference', $reference)->first();

        //     if($pay) {

        //         $pay->status = 1;
        //         $pay->verify = 1;
        //         $pay->save();
        //         $m = "You successfully make this payment";
        //         $s = 1;
        //     } else {
        //         $s = 0;
        //         $m = "Unable to update the payment pls contact support";
        //     }
    
        // } else if($verify['paymentStatus'] == 'PENDING') {
        //     $m = "Your Transaction is pending Contact us if you have been debited with your Payment Reference $reference";
        // } else{
        //     $m = "Failed verifying The Transaction Contact us if you have been debited with your Payment Reference $reference ";
            
        // }

    });
});

Route::prefix('/user')->group(function() {
    Route::middleware(['auth'])->group( function() {
        Route::match(['get', 'post'], '/{model}/ajax', [UserAjax::class, 'index']);
        Route::get('campaigns', [UserController::class, 'Campaigns'])->name('user.campaigns');
        Route::get('services', [UserController::class, 'Services'])->name('user.services');
        Route::get('wishes', [UserController::class, 'Wishes'])->name('user.wishes');
        Route::get('messages', [UserController::class, 'Messages'])->name('users.messages');
        Route::get('service-requirement', [UserController::class, 'ServiceRequirement']);
        Route::get('wallet', [UserController::class, 'Wallet'])->name('wallet');
        Route::get('payments', [UserController::class, 'Payments'])->name('user.payment');
        Route::get('activities', [UserController::class, 'Activity'])->name('user.activity');
        Route::get('profile', [UserController::class, 'Profile'])->name('profile');
        Route::get('edit-profile', [UserController::class, 'editProfile'])->name('edit-profile');
        Route::get('edit-bank', [UserController::class, 'editBank'])->name('edit-bank');
        Route::get('edit-password', [UserController::class, 'changePass'])->name('changepass');
        Route::get('reviews', [UserController::class, 'Reviews'])->name('user.review');
        Route::get('context', [UserController::class, 'Context'])->name('user.context');
        Route::get('add-context', [UserController::class, 'addContext'])->name('user.add-c');
        Route::get('dashboard', [UserController::class, 'Dashboard'])->name('user.dashboard');
        Route::match(['get', 'post'], '/ajax',[UserAjax::class, 'Ajax']);
    });
});


