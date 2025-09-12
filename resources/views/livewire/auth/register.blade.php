<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $n_code = '';
    public int $iranian = 1;

    public function check_n_code()
    {

        if ($this->iranian){

        }

    }


}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('ایجاد حساب کاربری')" :description="__('برای شروع ثبت نام اطلاعات خواسته شده را وارد کنید.')" />
    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="check_n_code" class="flex flex-col gap-6" autocomplete="off">

        <flux:radio.group wire:model="iranian" label="میلت" variant="cards" class="max-sm:flex-col">
            <flux:radio value="1" label="ایرانی" />
            <flux:radio value="0" label="اتباع خارجه"/>
        </flux:radio.group>
        <flux:input wire:model="n_code" :label="__('کدملی')" type="text" class:input="text-center"
                    style="direction:ltr" maxlength="10" required autofocus/>

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('ادامه') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('حساب کاربری داشته اید؟') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('وارد شوید') }}</flux:link>
    </div>
</div>
