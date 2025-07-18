<?php

use App\Models\Permission;
use Flux\Flux;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {

    #[Validate('required|unique:roles|min:2')]
    public string $name_fa = '';
    #[Validate('required|unique:roles|min:3')]
    public string $name_en = '';

    public function create(): void
    {
        $this->validate();
        Permission::create([
            'name_fa' => $this->name_fa,
            'name_en' => $this->name_en,
            'created' => j_d_stamp_en()
        ]);
        $this->modal('create_permission')->close();
        $this->dispatch('permission-created');
        $this->reset();
        Flux::toast(
            heading: 'انجام شد.',
            text: 'مجوز جدیدی افزوده شد.',
            variant: 'success'
        );
    }


}; ?>

<section class="absolute left-1 top-2">
    <flux:modal.trigger name="create_permission">
        <flux:button x-on:click.prevent="$dispatch('open-modal', 'create_permission')" variant="ghost" size="sm"
                     class="cursor-pointer">
            <flux:icon.plus-circle class="text-green-500"/>
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="create_permission" :show="$errors->isNotEmpty()" focusable class="w-80 md:w-96" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg" class="text-blue-500">{{ __('درج مجوز جدید') }}</flux:heading>
                <flux:text class="mt-2 text-blue-400">{{ __('توجه کنید این مجوز را قبلا تعریف نکرده باشید.') }}</flux:text>
            </div>
            <form wire:submit="create" class="flex flex-col gap-6">
                <flux:input wire:model="name_fa" :label="__('عنوان فارسی')" type="text" class:input="text-center"
                            maxlength="35" required autofocus/>
                <flux:input wire:model="name_en" :label="__('عنوان لاتین')" type="text" class:input="text-center"
                            maxlength="35" required style="direction:ltr"/>

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
