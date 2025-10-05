<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

Volt::route('questions', 'questions.list')->name('questions_list')->middleware('auth');

Volt::route('roles', 'role.index')->name('roles')->middleware('auth');
Volt::route('role/{role}/show', 'role.show')->name('show_role')->middleware(['auth', 'signed']);


Volt::route('permissions', 'permission.index')->name('permissions')->middleware('auth');
Volt::route('permission/{permission}/show', 'permission.show')->name('show_permission')->middleware(['auth', 'signed']);

Volt::route('institutes', 'institute.index')->name('institutes')->middleware('auth');
Volt::route('institute/{institute}/originators', 'institute.originators')->name('institute_originators')->middleware(['auth', 'signed']);

Volt::route('users', 'user.index')->name('users')->middleware('auth');
Volt::route('user/{user}/show', 'user.show')->name('show_user')->middleware(['auth', 'signed']);

use App\Http\Controllers\SmsTestController;

Route::get('/sms-test', [SmsTestController::class, 'send']);

