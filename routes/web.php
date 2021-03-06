<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Mail\InvoiceEmail;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Frontend
Route::get('/',function(){
    return view('welcome');
});

//Backend

Route::prefix('/')->middleware(['auth', 'verified'])->group(function(){

   // ressorce route start
    Route::get('dashboard', function () {

        $user = User::find(Auth::user()->id);

       return view('dashboard')->with([
           'user'            => $user,
           'activity_logs'   => ActivityLog::where('user_id' , Auth::id())->latest()->get(),
           'pending_tasks'   => $user->tasks->where('status', 'pending'),
           'unpaid_invoices' => $user->invoices->where('status', 'unpaid'),
           'paid_invoices' => $user->invoices->where('status', 'paid'),
       ]);
    })->name('dashboard');
    //User route
    Route::resource('user', UserController::class);
    //client route
    Route::resource('client', ClientController::class);

    //Tasks by Client



    //tasks Route
    Route::resource('task', TaskController::class);

    Route::put('task/{task}/complete',[TaskController::class,'markAsComplete'])->name('markAsComplete');


    // ressorce route end


    // route start invoice route
    Route::prefix('invoices')->group(function(){
        Route::get('/', [InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('create', [InvoiceController::class, 'create'])->name('invoice.create');
        Route::put('invoice/{invoice}/update', [InvoiceController::class, 'update'])->name('invoice.update');
        Route::delete('invoice/{invoice}/delete', [InvoiceController::class, 'destroy'])->name('invoice.destroy');

        // menual route start invoice preview & generate route
        Route::get('invoice', [InvoiceController::class, 'invoice'])->name('invoice');
        // menual route start invoice send email generate route
        Route::get('email/send/{invoice:invoice_id}', [InvoiceController::class, 'sendEmail'])->name('invoice.sendEmail');

        // menual route start invoice route


    });

    Route::get('settings',[SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/update',[SettingsController::class, 'update'])->name('settings.update');


});

require __DIR__.'/auth.php';
