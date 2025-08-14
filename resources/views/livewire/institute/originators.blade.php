<?php

use App\Models\Institute;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new class extends Component {
    #[Locked]
    public Institute $institute;
}; ?>

<div>
    <div class="bg-zinc-100 dark:bg-zinc-600 dark:text-zinc-300 py-3 relative">
        <p class="font-semibold text-center">{{__('لیست موسسان آموزشگاه ')}} {{$institute['short_name']}}</p>
        <section class="absolute left-1 top-2">
            <flux:tooltip content="آموزشگاهها" position="right">
                <flux:button href="{{route('institutes')}}" variant="ghost" size="sm" class="cursor-pointer" wire:navigate>
                    <flux:icon.arrow-up-circle class="text-blue-500 size-6"/>
                </flux:button>
            </flux:tooltip>
        </section>

    </div>
</div>
