<?php

use App\Livewire\CartPage;
use App\Livewire\HomePage;
use App\Livewire\CancelPage;
use App\Livewire\SuccessPage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductsPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\CategoriesPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\ProductDetailPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Http\Controllers\PaymentController;




//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', HomePage::class);
Route::get('/categories',CategoriesPage::class);
Route::get('/products',ProductsPage::class);
Route::get('/cart',CartPage::class);
Route::get('/products/{slug}',ProductDetailPage::class);//->name('products.show');

Route::middleware('guest')->group(function(){
    Route::get('/login',LoginPage::class)->name('login');
    Route::get('/register',RegisterPage::class);
    Route::get('/forgot',ForgotPasswordPage::class)->name('password.request');
    Route::get('/reset/{token}',ResetPasswordPage::class)->name('password.reset');
});

Route::middleware('auth')->group(function(){
    Route::get('/logout',function(){
        auth('web')->logout();//web = x 
        return redirect('/');
    });
    Route::get('/checkout',CheckoutPage::class);
    Route::get('/my-orders',MyOrdersPage::class);
    Route::get('/my-orders/{order_id}',MyOrderDetailPage::class)->name('my-orders.show');

    Route::get('/success',SuccessPage::class)->name('success');
    Route::get('/cancel',CancelPage::class)->name('cancel');
});


Route::get('/payment/snap-token/{orderId}', [PaymentController::class, 'getSnapToken'])->name('payment.snap-token');
Route::post('/payment/notification', [PaymentController::class, 'handleNotification'])->name('payment.notification');

