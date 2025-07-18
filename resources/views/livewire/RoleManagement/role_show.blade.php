<?php

use App\Models\Role;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new class extends Component {
    #[Locked]
    public Role $role;





}; ?>

<div>
    <div class="bg-zinc-100 dark:bg-zinc-600 dark:text-zinc-300 py-3 relative">
        <p class="font-semibold text-center">{{__('جزئیات نقش کاربری:')}} ( {{$role['name_fa']}}، {{$role['name_en']}} )</p>
{{--        <livewire:RoleManagement.role_create/>--}}
    </div>




</div>
