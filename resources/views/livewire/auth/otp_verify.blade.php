<?php

use App\Rules\NCode;
use App\Services\ParsGreenSmsService;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')]
class extends Component {
    public string $n_code;
    public string $mobile_nu;

    public function mount(): void
    {
        $this->send();
    }

    public function send()
    {
        $sms = new \App\Services\ParsGreenService();

        $result = $sms->sendSms('09034336111', 'سلام از لاراول 👋');

        return response()->json($result);
    }


}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('تایید کد پیامکی')"
                   :description="__('دکمه ارسال را کلیک نموده و کد دریافتی را ثبت نمایید.')"/>
    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')"/>
    <form wire:submit="check_n_code" class="flex flex-col gap-6" autocomplete="off">

        <flux:input wire:model="u_otp" :label="__('کدپیامک شده:')" type="text" class:input="text-center font-bold"
                    style="direction:ltr" maxlength="6" required autofocus/>

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" color="teal" class="w-full cursor-pointer">
                {{ __('تایید') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('شماره موبایل اشتباه وارد شده است؟') }}
        <flux:link href="{{URL::SignedRoute('register', ['n_code'=>$n_code, 'mobile_nu'=>$mobile_nu])}}"
                   wire:navigate>{{ __('اصلاح کنید') }}</flux:link>
    </div>
    <flux:button type="button" variant="primary" color="teal" class="w-full cursor-pointer" wire:click="send">
        {{ __('hvshg') }}
    </flux:button>


</div>
