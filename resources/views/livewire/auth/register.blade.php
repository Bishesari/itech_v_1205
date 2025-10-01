<?php

use App\Models\Mobile;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public $n_code;
    public $mobile;
    public $mobile_nu;

    public function check_n_code()
    {
        //در هرصورت شماره موبایل ذخیره شود
        $this->mobile = Mobile::storeOrUpdate($this->mobile_nu);
        $profile = Profile::where('n_code', $this->n_code)->first();
        if ($profile) {
            // کاربر قبلاً ثبت‌نام کرده
            return response()->json([
                'status' => 'exists',
                'message' => 'این کد ملی قبلاً ثبت شده. لطفاً وارد شوید.'
            ]);
        }
        // open modal to send top


    }

}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('ایجاد حساب کاربری')"
                   :description="__('برای شروع ثبت نام اطلاعات خواسته شده را وارد کنید.')"/>
    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')"/>
    <form wire:submit="check_n_code" class="flex flex-col gap-6" autocomplete="off">

        <flux:input wire:model="n_code" :label="__('کدملی:')" type="text" class:input="text-center font-bold"
                    style="direction:ltr" maxlength="10" required autofocus/>
        <flux:input wire:model="mobile_nu" :label="__('موبایل:')" type="text" class:input="text-center font-bold"
                    style="direction:ltr" maxlength="11" required/>

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
