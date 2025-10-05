<?php

use App\Models\Contact;
use App\Rules\NCode;
use Illuminate\Support\Facades\URL;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')]
class extends Component {
    public string $n_code;
    public string $mobile_nu;
    public string $contact;

    public function mount()
    {
        if ($this->n_code == '0' or $this->mobile_nu == '0'){
            $this->n_code = '';
            $this->mobile_nu = '';
        }
    }

    protected function rules(): array
    {
        return [
            'n_code' => ['required', 'digits:10', new NCode],
            'mobile_nu' => ['required', 'starts_with:09', 'digits:11']
        ];
    }

    public function pre_check()
    {
        $this->validate();
        $this->contact = Contact::storeOrUpdate($this->mobile_nu);



        return redirect()->to(URL::temporarySignedRoute('register.otp_verify', now()->addMinutes(2),
            ['n_code'=>$this->n_code, 'mobile_nu' => $this->mobile_nu]
        ));
    }


}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('ایجاد حساب کاربری')" :description="__('برای ثبت نام اطلاعات خواسته شده را وارد کنید.')"/>
    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')"/>
    <form wire:submit="pre_check" class="flex flex-col gap-6" autocomplete="off">

        <flux:input wire:model="n_code" :label="__('کدملی:')" type="text" class:input="text-center font-bold"
                    style="direction:ltr" maxlength="10" required autofocus/>
        <flux:input wire:model="mobile_nu" :label="__('موبایل:')" type="text" class:input="text-center font-bold"
                    style="direction:ltr" maxlength="11" required/>

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" color="indigo" class="w-full cursor-pointer">
                {{ __('ادامه') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('حساب کاربری داشته اید؟') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('وارد شوید') }}</flux:link>
    </div>
</div>
