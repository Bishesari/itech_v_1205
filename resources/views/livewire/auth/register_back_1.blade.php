<?php

use App\Models\Mobile;
use App\Models\Profile;
use App\Rules\NCode;
use App\Services\OtpService;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $n_code;
    public string $mobile;
    public string $mobile_nu = '';

    protected function rules(): array
    {
        return [
            'n_code' => ['required', 'digits:10', new NCode],
            'mobile_nu' => ['required', 'starts_with:09', 'digits:11']
        ];
    }


    public string $err_txt = '';
    public string $err_head = '';
    public function check_n_code(): void
    {
        $this->validate();
        //در هرصورت بعد از اعتبارسنجی شماره موبایل ذخیره شود
        $this->mobile = Mobile::storeOrUpdate($this->mobile_nu);
        $profile = Profile::where('n_code', $this->n_code)->first();

        if ($profile) {
            // کاربر قبلاً ثبت شده — پیام خطا/راهنمایی
            $this->addError('n_code', 'این کد ملی قبلا ثبت شده است. لطفاً وارد شوید.');
            return;
        }

        // قبل از بازکردن مودال بررسی می شود که آیا دکمه ارسال می تواند فعال باشد یا خیر؟
        $this->can_send_otp();
        // مودال ارسال پیامک باز می شود.
        $this->modal('mobile_verify')->show();
        if ($this->err_head) {
            Flux::toast(
                variant: 'danger',
                heading: $this->err_head,
                text: $this->err_txt,
                position: "top center",
            );
        }
    }

    public int $wait_seconds = 0;
    public bool $enable_send = false;

    public function can_send_otp(): bool
    {
        $mobile = Mobile::where('mobile_nu', $this->mobile_nu)->first();
        if (time() - $mobile->otp_next_try_time >= 86400) {
            $mobile->otp_sent_qty = 0;
            $mobile->save();
        }
        if (time() < $mobile->otp_next_try_time) {
            $this->wait_seconds = $mobile->otp_next_try_time - time();
            return false;
        }
        if ($mobile->otp_sent_qty >= 5) {
            $this->err_head = 'محدودیت ارسال برای موبایل';
            $this->err_txt = 'شماره همراه ' . $this->mobile_nu . ' تا 24 ساعت مسدود شد.';
            return false;
        }

        $this->wait_seconds = 0;
        $this->enable_send = true;
        return true;
    }

    public function sendOtp(): void
    {
        $mobile = Mobile::where('mobile_nu', $this->mobile_nu)->first();
        if ($this->can_send_otp()) {
            $otp = NumericOTP();
            $mobile->otp = $otp;
            $mobile->otp_sent_qty += 1;
            $mobile->otp_next_try_time = time() + 120;
            $mobile->save();
            $this->enable_send = false;
            $this->wait_seconds = 120;
        } else {
            $this->enable_send = false;
        }
    }


    public function refresh_wait(): void
    {
        if ($this->wait_seconds > 0) {
            $this->wait_seconds -= 1;
            $this->enable_send = false;
        } else {
            $this->wait_seconds = 0;
            if ($this->can_send_otp()) {
                $this->enable_send = true;
            }
        }
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

    <!--------- Mobile Verification Modal --------->
    <flux:modal name="mobile_verify" class="md:w-96" :show="$errors->isNotEmpty()" focusable :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{__('تایید شماره موبایل')}}</flux:heading>
                <flux:text class="mt-2">{{__('کد پیامک شده به ')}} {{$mobile_nu}} {{__(' را وارد نمایید.')}}</flux:text>
            </div>
            <form wire:submit="check_otp" class="flex flex-col gap-6" autocomplete="off">
                <flux:input.group>
                    <flux:input wire:model="u_otp" class:input="text-center font-bold" placeholder="کد پیامک شده"
                                maxlength="6" required autofocus/>
                    @if($enable_send)
                        <flux:button wire:click="sendOtp" variant="primary" color="purple">{{__('ارسال پیامک')}}</flux:button>
                    @else
                        <flux:button variant="filled" disabled="true" class="w-1/3"
                                     wire:poll.keep-alive.visible.1s="refresh_wait">
                            {{ $wait_seconds }} {{__('ثانیه')}}
                        </flux:button>
                    @endif
                </flux:input.group>

                <div class="flex">
                    <flux:spacer/>
                    <flux:button type="submit" variant="primary" color="sky" class="w-full">{{__('ادامه')}}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
