<?php

use App\Models\Institute;
use Flux\Flux;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {

    #[Validate('required|min:2')]
    public string $short_name = '';
    #[Validate('required|min:3')]
    public string $full_name = '';
    #[Validate('required|unique:institutes|size:3')]
    public string $abb = '';
    #[Validate('required|max:5')]
    public int $remain_credit = 1000;

    public function create_institute(): void
    {
        $this->abb = strtoupper($this->abb);
        $this->validate();
        Institute::create([
            'short_name' => $this->short_name,
            'full_name' => $this->full_name,
            'abb' => $this->abb,
            'remain_credit' => $this->remain_credit,
            'created' => j_d_stamp_en()
        ]);
        $this->modal('create_institute')->close();
        $this->dispatch('institute-created');
        $this->reset();
        Flux::toast(
            heading: 'انجام شد.',
            text: 'آموزشگاه جدیدی افزوده شد.',
            variant: 'success'
        );
    }


}; ?>

<section class="absolute left-1 top-2">
    <flux:modal.trigger name="create_institute">
        <flux:tooltip content="درج آموزشگاه جدید" position="right">
            <flux:button x-on:click.prevent="$dispatch('open-modal', 'create_institute')" variant="ghost" size="sm"
                         class="cursor-pointer">
                <flux:icon.plus-circle class="text-green-500"/>
            </flux:button>
        </flux:tooltip>
    </flux:modal.trigger>

    <flux:modal name="create_institute" :show="$errors->isNotEmpty()" focusable class="w-80 md:w-96" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('درج آموزشگاه جدید') }}</flux:heading>
                <flux:text class="mt-2">{{ __('اطلاعات مربوط به آموزشگاه را وارد نمایید.') }}</flux:text>
            </div>
            <form wire:submit="create_institute" class="flex flex-col gap-6" autocomplete="off">
                <flux:input wire:model="short_name" :label="__('نام کوتاه فارسی')" type="text" class:input="text-center"
                            maxlength="25" required autofocus/>

                <flux:input wire:model="full_name" :label="__('نام کامل')" type="text" class:input="text-center"
                            maxlength="50" required/>

                <flux:input wire:model="abb" :label="__('علامت اختصاری')" type="text" class:input="text-center"
                            maxlength="3" required style="direction:ltr"/>

                <flux:input wire:model="remain_credit" :label="__('مانده اعتبار')" type="text" class:input="text-center"
                            maxlength="5" required style="direction:ltr"/>

                <div class="flex justify-between space-x-2 rtl:space-x-reverse flex-row-reverse">
                    <flux:button variant="primary" color="green" type="submit"
                                 class="cursor-pointer">{{ __('ثبت') }}</flux:button>
                    <flux:modal.close>
                        <flux:button variant="filled" class="cursor-pointer">{{ __('انصراف') }}</flux:button>
                    </flux:modal.close>
                </div>
            </form>
        </div>
    </flux:modal>
</section>
