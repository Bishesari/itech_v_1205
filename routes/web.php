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
Volt::route('roles', 'RoleManagement.roles')->name('roles')->middleware('auth');
Volt::route('role/{role}/show', 'RoleManagement.role_show')->name('show_role')->middleware(['auth', 'signed']);
Volt::route('permissions', 'RoleManagement.permissions')->name('permissions')->middleware('auth');
Volt::route('permission/{permission}/show', 'RoleManagement.permission_show')->name('show_permission')->middleware(['auth', 'signed']);
